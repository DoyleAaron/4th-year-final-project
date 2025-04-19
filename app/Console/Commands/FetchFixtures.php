<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;

class FetchFixtures extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'fetch:fixtures';

    /**
     * The console command description.
     */
    protected $description = 'Fetch upcoming Premier League fixtures and store them in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching fixtures...');

        // Create an HTTP client
        $client = new Client();

        // API request URL: adjust status if needed (e.g. SCHEDULED for upcoming)
        $apiUrl = 'https://api.football-data.org/v4/competitions/PL/matches?status=SCHEDULED';

        try {
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'X-Auth-Token' => env('FOOTBALL_DATA_API_KEY'),  // ensure your API key is in .env
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Loop through each fixture match
            foreach ($data['matches'] as $match) {
                // Extract relevant information
                $homeTeamName = $match['homeTeam']['name'];
                $awayTeamName = $match['awayTeam']['name'];
                $kickoff = Carbon::parse($match['utcDate'])->format('Y-m-d H:i:s');

                // Look up the teams in your teams table
                $homeTeam = DB::table('teams')->where('api_name', $homeTeamName)->first();
                $awayTeam = DB::table('teams')->where('api_name', $awayTeamName)->first();

                if (!$homeTeam || !$awayTeam) {
                    $this->warn("Team mapping not found for: $homeTeamName or $awayTeamName. Skipping match.");
                    continue;
                }

                // Insert or update the fixture in your database
                DB::table('fixtures')->updateOrInsert(
                    [
                        'home_team_id' => $homeTeam->id,
                        'away_team_id' => $awayTeam->id,
                        'kickoff' => $kickoff,
                    ],
                    [
                        'home_team_name' => $homeTeamName,
                        'away_team_name' => $awayTeamName,
                        'completed' => false,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $this->info("Fixture added: $homeTeamName vs $awayTeamName at $kickoff");
            }

            $this->info('Fixtures fetched and saved successfully.');
        } catch (\Exception $e) {
            $this->error('Error fetching fixtures: ' . $e->getMessage());
        }
    }
}
