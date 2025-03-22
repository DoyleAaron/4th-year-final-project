import requests
import pandas as pd
import time
from bs4 import BeautifulSoup

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

def find_table(file):
    # Load the HTML file with BeautifulSoup
    with open(file, "r", encoding="utf-8") as file:
        soup = BeautifulSoup(file, "lxml")  # You can also try 'lxml' if needed

    # Locate the <table> with id 'stats_standard'
    table = soup.find("table", {"id": "matchlogs_all"})

    if table:
        print("Found <table id='matchlogs_all'>.")
        # Print the first 500 characters of the table for inspection
        print("Preview of <table> content:\n", table.prettify()[:500])

        # Parse the table using pandas
        try:
            df = pd.read_html(str(table))[0]
            # Save the DataFrame to a CSV file
            df.to_csv("game_by_game_stats.csv", mode="a", header=False, index=False)
            print("Player stats saved to 'game_by_game_stats.csv'")
        except ValueError as e:
            print(f"Error parsing the table: {e}")
    else:
        print("No <table> with id 'matchlogs_all' found.")


if __name__ == "__main__":

    df = pd.read_csv("24_25_prem_player_stats_clean.csv")

    player_list = df["Player"].tolist()

    hyphenated_players = ["-".join(player.split()) for player in player_list] # This is to match the format of the URL

    test_list = hyphenated_players[:5]

    for player in test_list:
        url = f'https://fbref.com/en/players/e342ad68/matchlogs/2024-2025/{player}-Match-Logs'
        extract_html(url)
        time.sleep(5)

        find_table("player.html")