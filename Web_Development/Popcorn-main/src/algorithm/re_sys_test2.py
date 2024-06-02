#!/usr/bin/env python
# coding: utf-8

# In[2]:


import pandas as pd
import numpy as np
from gensim.corpora import Dictionary
from gensim.models import TfidfModel
from gensim.models import Word2Vec
from functools import reduce
import collections


# <!-- According to the user's rating history, combined with the item portrait, the portrait label of the movie with the movie viewing record is used as the initial label to hit the user back.
# Calculate the weight value of each initial label of the user by counting the number of times the user watched the label, and select TOP-N as the final portrait label of the user after sorting. -->
# <!-- 1.
# - Use the tags of each movie in tags.csv as candidate keywords for movies
# - Use TF·IDF to calculate the tfidf value of each movie's label, and select TOP-N keywords as movie portrait labels -->
# 
# <!-- 1. Extract user watch list
# 2. Match keywords for users according to the watch list and item portrait, and count the word frequency
# 3. Sort according to word frequency, keep up to TOP-k words, where K is set to 100, as the user's label -->

# In[3]:


def get_movie_dataset():
    _tags = pd.read_csv("tags.csv", usecols=range(1, 3)).dropna()
    tags = _tags.groupby("movieId").agg(list)

    movies = pd.read_csv("movies.csv", index_col="movieId")

    movies["genres"] = movies["genres"].apply(lambda x: x.split("|"))

    movies_index = set(movies.index) & set(tags.index)
    new_tags = tags.loc[list(movies_index)]
    ret = movies.join(new_tags)

    movie_dataset = pd.DataFrame(
        map(
            lambda x: (x[0], x[1], x[2], x[2] + x[3]) if x[3] is not np.nan else (x[0], x[1], x[2], []),
            ret.itertuples())
        , columns=["movieId", "title", "genres", "tags"]
    )

    movie_dataset.set_index("movieId", inplace=True)
    return movie_dataset


movie_dataset = get_movie_dataset()


# In[4]:


def create_movie_profile(movie_dataset):
    dataset = movie_dataset["tags"].values

    from gensim.corpora import Dictionary
    #Build a word bag according to the data set, count the word frequency, put all words into a dictionary, and use the index to obtain
    dct = Dictionary(dataset)
    #According to each piece of data, return the corresponding word index and word frequency
    corpus = [dct.doc2bow(line) for line in dataset]
    #Train the TF-IDF model, that is, calculate the TF-IDF value
    model = TfidfModel(corpus)

    _movie_profile = []
    for i, data in enumerate(movie_dataset.itertuples()):
        mid = data[0]
        title = data[1]
        genres = data[2]
        vector = model[corpus[i]]
        movie_tags = sorted(vector, key=lambda x: x[1], reverse=True)[:30]
        topN_tags_weights = dict(map(lambda x: (dct[x[0]], x[1]), movie_tags))
        
        for g in genres:
            #Add the category words and set the weight value to 1.0
            topN_tags_weights[g] = 1.0
        topN_tags = [i[0] for i in topN_tags_weights.items()]
        _movie_profile.append((mid, title, topN_tags, topN_tags_weights))

    movie_profile = pd.DataFrame(_movie_profile, columns=["movieId", "title", "profile", "weights"])
    movie_profile.set_index("movieId", inplace=True)
    return movie_profile


movie_dataset = get_movie_dataset()

movie_profile = create_movie_profile(movie_dataset)

# Go to the inverted_table dict and use the tag as the key to get the value. If it can't get it, return []
# # Put the id and weight of the movie into a tuple and add it to the list
# # Set the modified value back

def create_inverted_table(movie_profile):
    inverted_table = {}
    for mid, weights in movie_profile["weights"].iteritems():
        for tag, weight in weights.items():            
            _ = inverted_table.get(tag, [])        
            _.append((mid, weight))
            inverted_table.setdefault(tag, _)
    return inverted_table


inverted_table = create_inverted_table(movie_profile)


# 

# In[5]:

# """
# User portrait construction steps:
#
# According to the user's rating history, combined with the item portrait, the portrait label of the movie with the movie viewing record is used as the initial label to hit the user back
# Calculate the weight value of each initial label of the user by counting the number of times the user watched the label, and select TOP-N as the user's final portrait label after sorting.
# """
def create_user_profile():
    watch_record = pd.read_csv("ratings.csv", usecols=range(2),
                  dtype={"userId": np.int32, "movieId": np.int32})

    watch_record = watch_record.groupby("userId").agg(list)
    # print(watch_record)

    movie_dataset = get_movie_dataset()
    movie_profile = create_movie_profile(movie_dataset)

    user_profile = {}
    # Get the top 50 words with the most occurrences
    # # Take out the number of occurrences of the word with the most occurrences
    # # Use the number of times to calculate the weight The weight of the word with the most occurrence is 1
    for uid, mids in watch_record.itertuples():
        record_movie_prifole = movie_profile.loc[list(mids)]
        counter = collections.Counter(reduce(lambda x, y: list(x) + list(y), record_movie_prifole["profile"].values))      
        interest_words = counter.most_common(50)    
        maxcount = interest_words[0][1]
        interest_words = [(w, round(c / maxcount, 4)) for w, c in interest_words]
        user_profile[uid] = interest_words

    return user_profile

user_profile = create_user_profile()


# In[ ]:


# Movies recommended for user 1，you can change user id,(movie id , rating)


# In[6]:


user_profile = create_user_profile()

watch_record = pd.read_csv("ratings.csv", usecols=range(2),
                           dtype={"userId": np.int32, "movieId": np.int32})

watch_record = watch_record.groupby("userId").agg(list)

for uid, interest_words in user_profile.items():
    result_table = {}  
    for interest_word, interest_weight in interest_words:
        related_movies = inverted_table[interest_word]
        for mid, related_weight in related_movies:
            recom= result_table.get(mid, [])
            #recom.append(interest_weight)  # Only consider the user's level of interest
            # recom.append(related_weight)    # Only consider the movies of interest
            recom.append(interest_weight*related_weight)    # both
            result_table.setdefault(mid, recom)

    rs_result = map(lambda x: (x[0], sum(x[1])), result_table.items())
    rs_result = sorted(rs_result, key=lambda x: x[1], reverse=True)[:10]
    print(uid)
    print(rs_result)
    break
    


# In[7]:


import gensim
#Train word vectors to find the closest words to a word
sentence =list(movie_profile['profile'].values)
model =gensim.models.Word2Vec(sentence,window=3,min_count=1,epochs=20)
model.wv.most_similar(positive=['action'],topn=10) #you can change keyword here，topn mean top of the movies




from gensim.models.doc2vec import Doc2Vec,TaggedDocument

# Train the model and save Doc2Vec to represent an article through a vector, and an article corresponds to a movie
# The similarity of training, which represents the similarity of the movie
documents = [TaggedDocument([movieId],tags) for movieId,tags in movie_profile["profile"].iteritems()]





from gensim.models.doc2vec import Doc2Vec,TaggedDocument
documents = [TaggedDocument(words, [movie_id]) for movie_id, words in movie_profile["profile"].iteritems()]
model = Doc2Vec(documents, vector_size=100, window=3, min_count=1, workers=4, epochs=20)


# In[11]:
#-----------------------------test   part--------------------------
#input  tags for movie 6
words = movie_profile["profile"].loc[6]
inferred_vector = model.infer_vector(words)
#Find the most detailed n vectors of incoming vectors through doc2vecs, each vector representing a movie
sims = model.docvecs.most_similar([inferred_vector], topn=10)
