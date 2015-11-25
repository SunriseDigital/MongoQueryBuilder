# MongoQueryBuilder

## 概要

[PHP Mongo](http://php.net/manual/ja/book.mongo.php)のクエリー用配列を組み立てるクラス。

## Classes

### [Mqb_Builder](src/Mqb/Builder.php)

`Mqb_Query`生成用クラス。`Mqb_Query`を生成する`query()`メソッド以外はありません。`$bld->query()->add(...)`のような記法を使いたかったため。

### [Mqb_Query](src/Mqb/Query.php)

クエリを組み立てるメインクラス。

詳しい使い方は[ユニットテスト](tests/BuilderTest.php)を見てください。
