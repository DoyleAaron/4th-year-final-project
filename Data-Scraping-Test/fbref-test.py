import pandas as pd
import requests

# URL and headers
url = 'https://fbref.com/en/squads/19538871/Manchester-United-Stats#all_stats_standard'
headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36",
    "Accept-Language": "en-US,en;q=0.5",
    "Referer": "https://www.google.com/"
}

# Make a request to the page with headers
response = requests.get(url, headers=headers)
df_list = pd.read_html(response.text)
df = df_list[0]  # This is being used to select which table on the page to use
print(df.head())