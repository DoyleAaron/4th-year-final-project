import requests
import pandas as pd
import time
from bs4 import BeautifulSoup
import os
import random

def extract_html(url, output_file="player.html"):

    import os
    print("Current working directory:", os.getcwd())

    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36",
        "Accept-Language": "en-US,en;q=0.9",
    }

    response = requests.get(url, headers=headers)

    with open("player.html", "w", encoding="utf-8") as file:
        file.write(response.text)

def find_table(html_file, player_id, player_slug):
    """
    Load the HTML, locate the 'matchlogs_all' table,
    parse it into a DataFrame, then add columns for
    'player_id' and 'player_slug' before saving.
    """

    with open(html_file, "r", encoding="utf-8") as f:
        soup = BeautifulSoup(f, "lxml")

    table = soup.find("table", {"id": "matchlogs_all"})
    if not table:
        print("No <table id='matchlogs_all'> found in", html_file)
        return

    try:
        df = pd.read_html(str(table))[0]

        # Add your identifying columns
        df["player_id"] = player_id
        df["player_slug"] = player_slug

        # Append to CSV
        df.to_csv("game_by_game_stats.csv", mode="a", header=False, index=False)
        print(f"Appended data for player_id={player_id}, slug={player_slug} to 'game_by_game_stats.csv'")
    except ValueError as e:
        print(f"Error parsing the table: {e}")

def extract_id(html_file="fbref_page.html"):
    """
    Reads the provided HTML file (which is expected to be a stats page from FBref),
    finds each player's link (e.g. /en/players/123abc/Player-Name),
    and extracts both the 'player_id' (123abc) and the player's name or slug (Player-Name).

    Returns:
        A list of tuples: [(player_id, player_slug), (player_id, player_slug), ...]
        or however you decide to store the data.
    """

    if not os.path.exists(html_file):
        print(f"File {html_file} not found.")
        return []

    # Read and parse the HTML
    with open(html_file, "r", encoding="utf-8") as f:
        soup = BeautifulSoup(f, "lxml")

    # This is where you need to identify the correct table or tags to extract player info.
    # For example, if the stats table has id="stats_standard", you might do:
    table = soup.find("table", {"id": "stats_standard"})
    if not table:
        print("Table with id='stats_standard' not found.")
        return []

    # Or if players are in <td data-stat="player">. 
    # Then you can select all <td> elements with data-stat="player".
    # Each <td> has an <a> with the href that contains /players/<player_id>/
    player_cells = table.find_all("td", {"data-stat": "player"})
    if not player_cells:
        print("No player cells found in the table.")
        return []

    # We'll store the results here
    results = []

    for cell in player_cells:
        a_tag = cell.find("a")
        if not a_tag:
            # Some rows may not have a link if there's no player data
            continue

        href = a_tag.get("href", "")
        # e.g. href = "/en/players/9f7c837d/Ben-Godfrey"

        parts = href.split("/")
        # Typically: ["", "en", "players", "9f7c837d", "Ben-Godfrey"]
        if len(parts) >= 5 and parts[2] == "players":
            player_id = parts[3]       # "9f7c837d"
            player_slug = parts[4]    # "Ben-Godfrey"
            # Alternatively, you might parse the text: a_tag.text for "Ben Godfrey"
            # or do more splitting if you want the raw name. 
            # For now, let’s store the slug.

            results.append((player_id, player_slug))
        else:
            # If the URL doesn't match the expected pattern, skip or handle differently
            continue

    print(f"Found {len(results)} players with IDs.")
    return results

    # ChatGPT gave me this function as I was researching a way to extract player data from a webpage automatically.
    # I have modified it to suit my needs and to work with the data I have.


if __name__ == "__main__":
    player_data = extract_id("fbref_page.html")
    print("Extracted player data:\n", player_data)




if __name__ == "__main__":

    ids = extract_id("fbref_page.html")
    print(ids)

    # df = pd.read_csv("24_25_prem_player_stats_clean.csv")

    # player_list = df["Player"].tolist()

    # hyphenated_players = ["-".join(player.split()) for player in player_list] # This is to match the format of the URL

    # for player in ids:
    #     player_id = player[0]
    #     player_slug = player[1]
    #     url = f'https://fbref.com/en/players/{player_id}/matchlogs/2024-2025/{player_slug}-Match-Logs'
    #     extract_html(url)
    #     time.sleep(random.randint(11, 15))

    #     find_table("player.html", player_id, player_slug)