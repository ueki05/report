# README

## 機能洗い出し
- report (日報)
  - index
  - (show)
    - index内に作るなら今回は不要
  - (new)
    - index内に作るなら今回は不要
  - create
  - edit
  - update
  - (destroy)
    - 今回は不要
- user (ユーザー)
  - index
  - show
  - new
  - create
  - edit
  - update
  - destroy

## DB設計
- report
  - id
  - user_id
  - text
  - created_at
  - is_sent
- user
  - id
  - first_name
  - last_name
  - email
  - password
  - picture
