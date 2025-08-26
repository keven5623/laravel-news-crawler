import os
import requests
import feedparser
import psycopg2
from datetime import datetime


DB_HOST = os.environ.get("DB_HOST", "localhost")
DB_PORT = int(os.environ.get("DB_PORT", 5432))
DB_NAME = os.environ.get("DB_NAME", "laravel_db")
DB_USER = os.environ.get("DB_USER", "postgres")
DB_PASSWORD = os.environ.get("DB_PASSWORD", "password")

# PostgreSQL 連線
conn = psycopg2.connect(
    host=DB_HOST,
    port=DB_PORT,
    dbname=DB_NAME,
    user=DB_USER,
    password=DB_PASSWORD
)

cur = conn.cursor()

# BBC 國際新聞 RSS
rss_url = "http://feeds.bbci.co.uk/news/world/rss.xml"
feed = feedparser.parse(rss_url)

for entry in feed.entries:
    title = entry.title
    link = entry.link
    published = datetime(*entry.published_parsed[:6])
    
    cur.execute(
        "INSERT INTO news (title, url, published_at, created_at, updated_at) VALUES (%s,%s,%s,NOW(),NOW()) ON CONFLICT DO NOTHING",
        (title, link, published)
    )

conn.commit()
cur.close()
conn.close()

print(f"Fetched {len(feed.entries)} news items from RSS.")
