# libraries
import pandas as pd

# fbref table link
url_df = 'https://fbref.com/en/comps/Big5/gca/players/Big-5-European-Leagues-Stats#stats_gca'

df = pd.read_html(url_df)
print(df)