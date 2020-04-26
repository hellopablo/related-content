# Related Content Engine

A simple framework for analysing objects in your application and an API for finding related content. Bring-your-own analysers extract relation nodes from an object which can be used to find other objects which have similar nodes.

For example, you might have  `Article` and `Blog` objects which both have `categories`, this framework would allow you to easily define an analyser for both data types which extract category nodes, allowing you to find similarly categorised items.



## Table of contents

- [Installing](#installing)
- [Analysers](#analysers)
    - [Nodes](#relationship-nodes)
- [The Engine](#the-engine)
    - [Indexing](#indexing)
    - [Querying](#querying)
    - [Reading](#reading)
    - [Deleting](#deleting)
    - [Dump](#dump)
    - [Empty](#empty)
- [Data Stores](#data-stores)
    - [Ephemeral](#ephemeral)
    - [MySQL](#mysql)





## Installing

Install using Composer:

```bash
composer require hellopablo/related-content-engine
```

All classes within the package are under the namespace `HelloPablo\RelatedContentEngine` and can be autoloaded using PSR-4. Examples below assume a `use HelloPablo\RelatedContentEngine` statement has been used.





## Analysers

A key concept in this framework is that of Analysers. Analysers are classes which implement the `Interfaces\Analyser` interface. Their purpose is to examine your objects and extract data points (nodes) which can be used for indexing.

It is expected that each distinct type of data in your application has its own analyser, *even if they share a similar structure*. Internally the enigne uses the analyser as a key to differentiate between data types.

> 🧑‍💻 It is important to understand that an analyser is something that is provided by your application. The framework has no opinions on what your data looks like, nor does it infer any relationships – it is up to you to extract relationship data.



### **Relationship Nodes**

A relationship node is a single data point which describes a part of the object which is being indexed. Nodes implement the `Interfaces\Relation` interface and should define a `type` and a `value`. Typically, the `type` is an application supplied string which describes the node (e.g. `CATEGORY`, `TOPIC`, or `AUTHOR`) and the `value` is an ID or other identifier of the `type`.

> 🙋 The framework provides a `Relation\Node` class which you can use in your application's analysers.



**Example**

For an object which looks like this:

```json
{
    "id": 1,
    "label": "My Article",
    "body": "Nullam id dolor id nibh ultricies ... auctor fringilla.",
    "categories": [1, 2, 3],
    "topics": [5, 6, 7]
}
```

We might want to describe the `categories` and `topics` IDs as relationship nodes. In this example, the analyser would look like this:

```php
namespace App\RelatedContent\Analysers;

use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Relation;

class Article implements Interfaces\Analsyer
{
    /**
     * Analyses an item and returns an array of Interfaces\Relation
     *
     * @param object $item The item to analyse
     *
     * @return Relation\Node[]
     */
    public function analyse(object $item): array
    {
        $nodes = [];

        foreach ($item->categories as $categoryId) {
            $nodes[] = new Relation\Node('CATEGORY', $categoryIdid);
        }

        foreach ($item->topics as $topicId) {
            $nodes[] = new Relation\Node('TOPIC', $topicId);
        }

        return $nodes;
    }

    /**
     * Returns the item's unique identifier
     *
     * @param object $item
     *
     * @return int
     */
    public function getId(object $item)
    {
      return $item->id;
    }
}
```

Other analysers (say, for a blog posts) might also return `CATEGORY` and `TOPIC` nodes, too. It's the overlap of the node types and values which are considered to be relations.





## The Engine

The `Engine` is how your application will [mostly] interact with the related content store. It facilitates reading and writing from the [data store](#data-stores), as well as providing an interface for indexing your content using [analysers](#analysers).

A new instance of the enigne can be retrieved via the `Factory` class, you must pass an instance of the [data store](#data-stores) you wish to use.

An example using the [MySQL data store](#data-stores):

```php
use HelloPablo\RelatedContentEngine;

$store = new RelatedContentEngine\Store\MySQL([
    'user'     => 'mysql_user',
    'password' => 'mysql_password',
    'database' => 'mysql_database',
]);

/** @var Engine $engine */
$engine = RelatedContentEngine\Factory::build($store);
```



### Indexing

Indexing is the process of analysing an object and saving it's relationship nodes to the data store. This can be achieved using the engine's `index(object $item, Interfaces\Analyser $analyser): self` method.

```php
use App\RelatedContent\Analysers;

/**
 * The item we wish to index. This would typically be retrieved using a
 * model, an ORM or some other app-orientated struct.
 */
$item = (object) [
    'id'         => 1,
    'label'      => 'My Article',
    'body'       => 'Nullam id dolor id nibh ultricies ... auctor fringilla.',
    'categories' => [1, 2, 3],
    'topics'     => [5, 6, 7]
    
];

$analyser = new Analysers\Article();

$engine->index($item, $analyser);
```

> 💁 Indexing an item will delete all previously held data for that item.



### Querying

Querying is the core functionality of this library – by providing a source item (and its analyser) the engine can find matching items and return hits, sorted by score (most related first). Your application can then use these results to then fetch the source items.

Querying is facilitated by the engine's `query` method. This method accepts four arguments:

1. The source item, i.e the item we want to find related content for.
2. The source item's analyser, i.e. the analyser used to index the item.
3. Any data types to restrict results to, passed as an array of analysers, i.e we only want to see related `Blog` results for our source `Article`.
4. The number of results to return.



The query method is best explained using an example. Assuming this system stores relational data about two datatypes: `Article` and `Blog`, we might have the following analysers:

```php
use App\RelatedContent\Analysers;

$articleAnalyser = new Analysers\Article();
$blogAnalyser    = new Analysers\Blog();
```



Each of these analysers extracts `category` data for their respective data-types. With our source `Article` item to hand, we can find related `Article` and `Blog` content like so:

```php
/**
 * The item which was indexed; at minimum you need the analyser
 * to be able to acertain the item's ID.
 */
$articleItem = (object) [
    'id' => 1,
];

$results = $engine->query(
	$articleItem,
    $articleAnalyser
);
```



The `$results` array will be an array of `Query\Hit` objects. These objects provide three methods:

1. `getAnalyser(): Interfaces\Analyser` which will return an instance of the analyser used to index the item.
2. `getId(): string|int` which will return the indexed item's ID.
3. `getScore(): int` which will return the score of the hit.



If we wanted to restrict the reuslts to contian just a certain data type(s) then we would pass in an array of analyser instances we'd like to restrict to as the third argument, additionally, we can limit the results too by passing an integer as the fourth argument:

```php
/**
 * The item which was indexed; at minimum you need the analyser
 * to be able to acertain the item's ID.
 */
$articleItem = (object) [
    'id' => 1,
];

/**
 * Return up to 3 related blog posts for our article.
 */
$results = $engine->query(
	$articleItem,
    $articleAnalyser,
    [
        $blogAnalyser
    ],
    3
);
```



### Reading

You can read all the data stored about a particular item using the engine's `read(object $item, Interfaces\Analyser $analyser): Interfaces\Relation[]` method:

```php
use App\RelatedContent\Analysers;

/**
 * The item which was indexed; at minimum you need the analyser
 * to be able to acertain the item's ID.
 */
$item = (object) [
    'id' => 1,
];

$analyser = new Analysers\Article();

$relations = $engine->read($item, $analyser);
```



### Deleting

To delete all data held about an item, use the engine's `delete(object $item, Interfaces\Analyser $analyser): self` method:

```php
use App\RelatedContent\Analysers;

/**
 * The item which was indexed; at minimum you need the analyser
 * to be able to acertain the item's ID.
 */
$item = (object) [
    'id' => 1,
];

$analyser = new Analysers\Article();

$relations = $engine->delete($item, $analyser);
```



### Dump

If you need to dump the entire contents of the [data store](#data-stores), you may use the engine's `dump(): array` method. It will return an array of all relations stored in the [data store](#data-stores).

```php
$items = $engine->dump();
```



### Empty

To *destrictively* empty the [data store](#data-stores) you may use the engine's `empty(): self` method. this cannot be undone.

```php
$engine->empty();
```





## Data Stores

The data store is where the engine keeps its index data. You are free to sue any data store you like; all adapters must implement the `Interfaces\Store` interface. The package provides two stores by default:



### Ephemeral

#### `Store\Ephemeral(array $config = [])`

The Ephemeral store is an in-memory store. It's storage egine is an array and any data is not intended to be persisted beyond the life-span of the class instance (except, of course, if you manually serialize the object).

It is primarily used for the test suite, but is available as a first-class citizen should you have a need. An example use case for this store might be for a long-runnig script which builds up a relationship model and caches the results, the actual data store does not need to be persisted.

#### Configuration

This store accepts the following keys in the configuration array:

| Key            | Description                                                  | Default |
| -------------- | ------------------------------------------------------------ | ------- |
| `data`         | Any data to pre-seed the store with.                         | `[]`    |
| `will_connect` | Whether the store will "connect"; used to simualte connection faiulures in the test suite. | `true`  |



### MySQL

#### `Store\MySQL(array $config = [])`

This MySQL store allows you to use a MySQL table as the persistent data store for the relationship data. It utilises the `\PDO` class provided by PHP.

#### Configuration

This store accepts the following keys in the configuration array:

[^]: 

| Key           | Description                                    | Default                                                      |
| ------------- | ---------------------------------------------- | ------------------------------------------------------------ |
| `host`        | The host to connect to.                        | `127.0.0.1`                                                  |
| `user`        | The username to connect with.                  | `<blank>`                                                    |
| `pass`        | The password to connect with.                  | `<blank>`                                                    |
| `database`    | The database to use.                           | `<blank>`                                                    |
| `table`       | The name of the table to use.                  | `related_content_data` – note: this table will be automatically created on conenction if it does not already exist. |
| `port`        | The port to connect to.                        | `3306`                                                       |
| `charset`     | The character set to use.                      | `utf8mb4`                                                    |
| `pdo_options` | Any options to pass to the `\PDO` constructor. | [<br />    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,<br />\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,<br />\PDO::ATTR_EMULATE_PREPARES   => false,<br />] |



