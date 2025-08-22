# Laravel + Python News Crawler

本專案示範如何使用 **Laravel 排程**觸發 **Python 爬蟲**，抓取新聞資訊並寫入 **PostgreSQL**，並在 **Blade 頁面**顯示新聞列表。

backend 容器：Laravel + Scheduler

crawler 容器：Python 爬蟲

db 容器：PostgreSQL

---

## 專案架構

project-root/
├─ backend/ # Laravel 專案
│ ├─ app/Console/Kernel.php # Laravel 排程設定
│ ├─ app/Http/Controllers/NewsController.php
│ ├─ resources/views/news.blade.php
│ └─ ...
├─ crawler/ # Python 爬蟲
│ ├─ news_crawler.py
│ ├─ requirements.txt
│ └─ Dockerfile
├─ docker-compose.yml
└─ README.md

---

## 功能

- 使用 Python + BeautifulSoup 抓取新聞網站文章 (`article` 標籤)  
- 存入 PostgreSQL 資料庫  
- Laravel Scheduler 定時觸發爬蟲  
- Blade 頁面顯示最新新聞列表  

---

## 技術棧

- **後端**：Laravel 12 (PHP 8.2)  
- **爬蟲**：Python 3.11 + BeautifulSoup + psycopg2  
- **資料庫**：PostgreSQL 15  
- **容器化**：Docker / Docker Compose  
