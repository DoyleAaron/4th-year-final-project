#!/usr/bin/env python
# coding: utf-8

# ## Fixture Difficulty Rating
# - The aim for this  is to be able to give the user a category of how difficult their next game or next run of games is going to be for a player
# - This is going to be useful because fixtures are key for players in fantasy football
# - I was orignally going to try and use a machine learning model for this but I decided against it as I believe that making a formula that takes in teams form and league position will be more effective as it is a definitive thing.
# 

# In[1]:


import requests

url = 'https://fbref.com/en/comps/9/Premier-League-Stats'

headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36",
    "Accept-Language": "en-US,en;q=0.9",
}

response = requests.get(url, headers=headers)

with open("table-data.html", "w", encoding="utf-8") as file:
    file.write(response.text)

# This is extracting the raw html from the page into a local HTML file


# In[4]:


from bs4 import BeautifulSoup
import pandas as pd

# Path to your saved HTML file
html_file = "table-data.html"

# Load the HTML file with BeautifulSoup
with open(html_file, "r", encoding="utf-8") as file:
    soup = BeautifulSoup(file, "lxml")  # You can also try 'lxml' if needed

# Locate the <table> with id 'stats_defense'
table = soup.find("table", {"id": "results2024-202591_overall"})

if table:
    print("Found <table id='results2024-202591_overall'>.")
    # Print the first 500 characters of the table for inspection
    print("Preview of <table> content:\n", table.prettify()[:500])

    # Parse the table using pandas
    try:
        df = pd.read_html(str(table))[0]
        # Save the DataFrame to a CSV file
        df.to_csv("table.csv", index=False)
        print("Player stats saved to 'table.csv'")
    except ValueError as e:
        print(f"Error parsing the table: {e}")
else:
    print("No <table> with id 'results2024-202591_overall' found.")

# This code was obtained from ChatGPT and it is used to extract tables from HTML files using BeautifulSoup and pandas.


# I am following the same format that I have used for my previous models to obtain the data through a web scraper.
# 
# I found the data that I needed to obtain by going through the fbref website which I use for all of my data, I found the table that I needed and extracted the HTML for that page, once I found the table ID in the raw html of the league table that I needed I was able to extract that data into a csv so I can then use this for my new dataset for this model.

# In[13]:


import pandas as pd
import numpy as np
import sklearn

df = pd.read_csv('table.csv')

print(df.head())


# Here I'm just reading in the new csv that I extracted earlier on in the notebook.

# In[14]:


df.columns = df.columns.str.strip() # ChatGPT code to remove whitespace from column names
df = df.drop(['Attendance', 'Notes', 'Top Team Scorer', 'Goalkeeper', 'Pts/MP', 'xG', 'xGA', 'xGD', 'xGD/90'], axis=1)

df.to_csv('filtered_table.csv', index=False)


# Here I'm just removing whitespace from the column headers and then dropping the unnecessary columns and saving the results to a csv file.

# My plan for this is to use their current league position and then their form to build this formula. 
# 
# The way I want to incorporate the recent form into account is by getting a total based off of the last 5 results so it will be the same as the points system in real life:
#     - 3 points for a win
#     - 1 point for a draw
#     - 0 points for a loss
# 
# When I have this as a column for each team I can then do a check with their current league position added to their form points and then the difference of that score for both teams will indicate how easy or hard the fixture is.

# In[15]:


df = pd.read_csv('filtered_table.csv')

df["NewRank"] = 21 - df["Rk"]

print(df[["Rk", "NewRank", "Squad"]])



# I am doing this because I want the calculation for difficulty to work that the higher the score the tougher the team so for this 20 is top of the league and 1 would be the bottom
# 
# Now the next step is to create the column for the recent form.

# In[16]:


points_map = {
    "W": 3,
    "D": 1,
    "L": 0
}

df["Form_Rating"] = df["Last 5"].apply(
    lambda x: sum(points_map.get(result, 0) for result in x.split())
)


# I got ChatGPT to help me with this part as I was having trouble iterating thrugh all of them correctly and efficiently, now this field has an integer value for the recent form of the team.
# 
# I am going to have 3 categories for this, with easy, even and tough fixture.

# In[29]:


team_a_name = "Southampton"
team_b_name = "Leicester City"
difficultycategory = ""


def head_to_head(team_a_name, team_b_name, difficultycategory):
    team_a = df[df["Squad"] == team_a_name]
    team_b = df[df["Squad"] == team_b_name]

    total_a = team_a["NewRank"].values[0] + team_a["Form_Rating"].values[0]
    total_b = team_b["NewRank"].values[0] + team_b["Form_Rating"].values[0]

    difference = abs(total_a - total_b)

    if difference <10:
        difficultycategory = "Even"
    
    elif difference < 20:
        difficultycategory = "Medium"

    else:
        difficultycategory = "Hard"

    return total_a, total_b, difficultycategory


total_a, total_b, difficultycategory = head_to_head(team_a_name, team_b_name, difficultycategory)
print(f"{team_a_name} total: {total_a}")
print(f"{team_b_name} total: {total_b}") 
print(f"Difficulty Category: {difficultycategory}")


# This function now takes into account a teams recent form and their league position to be able to give the user an idea of how difficult their next fixture is going to be.
