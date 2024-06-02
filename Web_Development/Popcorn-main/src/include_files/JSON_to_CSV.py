#!/usr/bin/env python
# coding: utf-8

# In[14]:


import os
import pandas as pd
import numpy as np

#additional imports used
import requests
import json
import csv


# In[20]:


#URL that includes API key and request made to the API.
#More info on calls here: https://imdb-api.com/api

main_url = "https://imdb-api.com/API/AdvancedSearch/k_c4586ape"

#String that can be added to the full url to call specifc genres of movies. EX: genres="action"

genres = "?genres=adventure,animation"

#String that can be added to full url to call specifc group of movies. EX: groups=top_250 returns top 250 rated movies.
#If combined with a genre, it will return top_250 rated movies of that specific genre.

groups="&groups=top_250"

full_url = main_url + genres + groups

payload = {}
headers = {}
 
response = requests.request("GET", full_url, headers=headers, data = payload)


# In[21]:


#Response data from api encoded in utf-8
resp_data = json.loads(response.text.encode('utf8'))

#Getting results only from response data
mov_data = resp_data['results']

#opening csv file to write to and update whenever new call is made and this cell is ran.
#File name is data.csv.

data_file = open('data.csv','w+', newline='', encoding='utf-8')
csv_writer = csv.writer(data_file)

#Loop to convert results from JSON to CSV
count = 0
for data in mov_data:
    if count == 0:
        header = data.keys()
        csv_writer.writerow(header)
        count += 1
    csv_writer.writerow(data.values())
 
data_file.close()

