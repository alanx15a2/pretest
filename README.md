# 題目

## 服務

### 啟動服務  
`docker compose up -d`

### CLI
`docker exec -it asiayo-pretest-web-1 bash`


## 題目1 
請寫出⼀條查詢語句 (SQL)，列出在 2023 年 5 ⽉下訂的訂單，使⽤台幣付款且5⽉總⾦額最
多的前 10 筆的旅宿 ID (bnb_id), 旅宿名稱 (bnb_name), 5 ⽉總⾦額 (may_amount)

```sql
SELECT
    bnbs.id as bnb_id,
    bnbs.name as bnb_name,
    SUM(orders.amount) as may_amount
FROM bnbs
INNER JOIN orders on bnbs.id = orders.bnb_id
WHERE orders.created_at BETWEEN '2023-05-01 00:00:00' AND '2023-05-31 23:59:59'
  AND orders.currency = 'TWD'
GROUP BY bnbs.id, bnbs.name
ORDER BY may_amount DESC 
LIMIT 10;
```

## 題目2

在題⽬⼀的執⾏下，我們發現 SQL 執⾏速度很慢，您會怎麼去優化？請闡述您怎麼判斷與優
化的⽅式

1. 利用 EXPLAIN 去確認索引(currency、created_at)有正常建立並生效
2. 業務邏輯可行的話，created_at 修改為 not null，null 值可能會影響 mysql 的查詢優化器。
3. 確認 orders 表大小，若量較大(千萬up)，可以根據業務邏輯考慮 partition，可以有效降低資料量。
4. 由於看起來像是報表類的資料，可以考慮建立一表將結果存起來，下一次就可以用簡單的 SELECT 取得資料。
5. 確認各表負載，若有其他負載較高的表，可以考慮做分庫，降低伺服器負載。
6. 利用 SHOW VARIABLES 確認 (innodb_buffer_pool_reads/innodb_buffer_pool_read_request)，當這個值偏高，代表伺服器高機率無法從 innodb_buffer 處理資料，可以考慮加大 innodb_buffer_pool_size，不可超過實體記憶體的數值.

***以上僅限於資料庫方面優化***
