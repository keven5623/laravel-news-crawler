import requests
from bs4 import BeautifulSoup
import psycopg2
from datetime import datetime

# PostgreSQL 連線
conn = psycopg2.connect(
    host="db",        
    dbname="laravel_db",
    user="postgres",
    password="password"
)
cur = conn.cursor()

url = "https://www.bbc.com/news" 
res = requests.get(url)
soup = BeautifulSoup(res.text, "html.parser")

articles = soup.find_all("article")  # 根據網站結構調整

for article in articles:
    title_tag = article.find("h2")
    link_tag = article.find("a")
    if not title_tag or not link_tag:
        continue
    title = title_tag.text.strip()
    link = link_tag['href']
    published = datetime.now()
    cur.execute(
        "INSERT INTO news (title, url, published_at, created_at, updated_at) VALUES (%s,%s,%s,NOW(),NOW()) ON CONFLICT DO NOTHING",
        (title, link, published)
    )

conn.commit()
cur.close()
conn.close()
