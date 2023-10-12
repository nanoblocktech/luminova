# luminova
PHP Luminova framework built for speed and keeping your existing coding skills going.

## Under Construction

```bash
composer create-project nanoblocktech/luminova
```
```bash
composer create-project nanoblocktech/luminova project-root
```
```bash
$ git clone https://github.com/nanoblocktech/luminova
$ composer install
$ composer test
```

Let start by creating for first website using Luminova framework

First thing to do is configure your web server to use custom document root which should be `path/to/your/project/public`.
Assuming your existing document root is `user/var/www/public_html` now you have to change it to `user/var/www/project/public` or `user/var/www/public_html/public`. The `project` or `public_html` will server as your private document root where the framework files will be located which is not accessible from web browsers.

#### Document Roo Configuration Samples

```bash 

```
*IMPORTANT*
Makes your set required permissions for `public` directory to be accessible in browsers.

Now that we are done setting up our website document root let head to uploading our project online.
Upload your project version which is located on `builds/v-{*}` folder, to your project private directory.


#### Front Controller Routing 


```php 
require_once(__DIR__ . '/../system/plugins/autoload.php');
use \App\Controllers\Application;

/*
    Initialize your application instance
*/
$app = new Application(__DIR__);

/*
Grab our application instance
*/
$router = $app->getRouterInstance();

$router->beforeMiddleware('GET|POST', '/.*', function () {
    /*
        Set up your website global security here such as session etc....
        Or you can also do it in bind
    */
});

/*
    Landing page goes here if you need to
*/
$router->get('/', function() use ($app) {
    /*
        Render your landing page view
    */
    return $app->render("index")->view();
});

// More routing goes on

/*
    Run your application
*/
$router->run();
```

#### Front Controller Routing Methods

Route to your controller class 
```php
$router->get('/hello', 'HelloWorld::show');
```
Route to user profile controller class 

```php
$router->get('/user/(.*)', 'UserController::profile');
```
Route `POST` to update user profile controller class 

```php 
$router->post('/user', 'UserController::update');
```
Bind multiple routes 
```php
$router->bind('/foo', function() use ($router, $app) {

    $router->get('/', function() use ($router, $app) {
        return $app->render("foo")->view();
    });

    $router->get('/bar/([a-zA-Z0-9]+)', function($id) use ($app) {
        return $app->render("bar")->view([
            "id" => $id
        ]);
    });
});
```

Loading template view from sub folder in `resources/views` directory. example `resources/views/admin`

```php
$router->bind('/admin', function() use ($router, $app) {
    $router->get('/', function() use ($router, $app) {
        return $app->setFolder("admin")->render("foo")->view();
    });

    $router->get('/foo/([a-zA-Z0-9]+)', function($id) use ($app) {
        return $app->setFolder("admin")->render("bar")->view([
            "id" => $id
        ]);
    });
});
```

#### Creating Templates Views

To create your html view template you must do that inside `resources/views` or if you have s sub directory inside.
When you pass an array parameter to your `render("user")->view([...])`, you can get the values in your template by simply echoing the key using `$this` keyword and underscore `_`, before the key name. example `echo $this->_name`.

To access a class instance you registered in your application controller you don't need underscore `_`, You can just call `$this->MyClass->doSomething()` depending on the name you have registered your class instance with.

user.php 
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Luminova User</title>
</head>
<body>
	<h1>Welcome {<?=$this->_name;?>}</h1>
    <a href="<?=$this->_base;?>">Home</a>
</body>
</html>
```

#### Templates Global Variables

Variable         |                                                                                   | Modifiable
-----------------|-----------------------------------------------------------------------------------|-------------
$this->_base     | Get your base directory, using it withing any view will return you to home view   | Yes
$this->_active   | get the current view name                                                         | No
$this->_title    | Get the current view page title                                                   | Yes
$this->_subtitle | Get the current view subtitle                                                     | Yes
$this->_assets   | Get assets folder                                                                 | No
ALLOW_ACCESS     | Define if only template class can access and render view                          | No
$this->_ContentType | Get view content type | Yes
$this->_optimize  | Get view optimizer state | Yes


#### Configuring Templates View

To configure your template view you can pass array options to render view.

```php 
$app->render("bar")->view([
    "active" => "String: Set the name of activate view,
    "ContentType" => "String: Set the rendering content type of view [json, text or html], the default is html",
    "optimize" => "Boolean: Enable or disable view optimization. The default is true. But before it work you have to enable it in your initialization environment config file .env",
    "title" => "String: Set view title"
    "subtitle" => "String: Set view subtitle",
    "base" => "String: Set project base directory",
    "assets" => "String: Set project assets directory"
]);
```

#### Configuring Your Application
Your application class is located in `app/Controllers/` directory.
This is where you can configure how your application behave and most important do not forget to extend `BaseApplication`.
Your `Application` class should look something like this  

```php 
namespace App\Controllers;
use \Luminova\BaseApplication;
class Application extends BaseApplication  {
    
}
```

In other to add custom configurations you need to initialize your `__construct`, and also `parent::__construct()`, set the example below.

```php 
namespace App\Controllers;
use \Luminova\BaseApplication;
class Application extends BaseApplication  {
    public function __construct(string $dir = __DIR__){
        /**
         *  Initialize session manager if you want to make use of sessions
        */

        /**
        * Register global classes to use across your application life cycle
        */

        /**
        * Initialize parent constructor
        */

        parent::__construct($dir);

        /**
        * Do your other business here
        */
	}
}
```

#### Class Registration Method

Register your class by referencing the class name 
```php
$this->registerClass(MyClass::class); 
```

Register your class with a custom name and pass class instance in second argument
```php 
$this->registerClass("MyClass", new MyClass(arguments));
```

Register your class by passing the class instance
```php 
$this->registerClass(new MyClass(arguments));
```

To use meta schema you must first register the class to your application as below 

```php 
$this->registerClass(new Meta(parent::appName(), parent::getRootDirectory(), parent::baseUrl()));
```
Then you can start using it across your application views.

Setting your project canonical url version
```php
$this->Meta->setCanonicalVersion("https://www.example.com/", $this->getView());
//OR
$this->Meta->setCanonicalVersion(parent::baseUrl(), $this->getView());
```
#### Meta Class Methods

Method                        | Description
------------------------------|-------------------
setConfig(array $config): void | Set your current view schema configuration
setLink(string $link): self   | Set current view link
setTitle(string $title): void | Set current view title
setCanonical(string $canonical): void | Set current view canonical
setCanonicalVersion(string $link, string $view) | Set current view canonical version
setPageTitle(string $title): void | Set current view page title
toJson(): string | Get json representation of your view schema object
generateScheme(): array | Get array representation of your view schema object
getMetaTags(): string | Get view meta tags
getObjectGraph(): string | Get schema object graph


#### Meta Class Scheme Configuration Options 
To configure your scheme default variables, it can be done in `meta.config.json` on your framework root directory.
Other variable can be change according to view as wells as the default options too.
```php 
[
    "link" => "Current view url link",
    "canonical" => "Current view url canonical version",
    'image_assets' => "Project images assets link",
    'company' => "Company",
    "company_name" => "Company name",
    "description" => "Project description",
    "company_description" => "Company description",
    "title" => "Current view title",
    "caption" => "Image caption",
    "image_name" => "Image filename example foo.png",
    "image_width" => "Image width",
    "image_height" => "Image height",
    "image_type" => "Image type example image/png",
    "datePublished" => "For post publish date",
    "dateModified" => "For post modified date",
    "keywords" => "Project keywords",
    "isArticle" => "Boolean: is current view an article [true|false]",
    "isProduct" => "Boolean: is current view a product [true|false]",
    "article_keywords" => [
        "Article keywords"
    ],
    "article_category" => "Article category",
    "author" => "Author name",
    "twitter_name" => "Twitter name"
    "image_link" => "Project finest image link",
    "category" => "Product Category",
    "availability" => "Product availability",
    "currency" => "Product currency",
    "price" => "Product price",
    "brand" => "Product brand",
]
```

#### Creating And Managing Controllers

Controller class is responsible in handling your view logics. Makes sure to extend `BaseController` whenever you create a new controller.

An example of controller should be like 

```php 
namespace App\Controllers;
use Luminova\BaseController;

class UserController extends BaseController{

}
```

Now to work with your new create controller you must initialize it parent class `parent::__construct()` inside the controller constructor method.

Now we create a new Model `UserModel`, to use in controller class.
The model will handle your user information and user related logics.
To create a model you must do that inside `app/controllers/Models/`, your `UserModel` should have 3 protected properties defined `$table` The database table name where user information stored, `$primaryKey` The column key for user primary key and `$allowedFields` The allowed columns fields to update.

**Important Note:** While creating a model you must extend base `Model`

```php
namespace App\Controllers\Models;
use Luminova\Models\Model;
class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'uid';
    protected $allowedFields = ['name', 'age', 'email']; 
}

```

Once done creating your user model you can handle other thing in `UserController`.
Import and prepare your `UserModel` in `UserController` by using `use` keyword.

Since you are going to be working on `UserController`, make sure to initialize its parent construction `parent::__construct()` in your `UserController` __construct method before anything.

```php
namespace App\Controllers;
use Luminova\BaseController;
use App\Controllers\Models\UserModel;

class UserController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->validate->setRules([
            'name' => 'required',
            'age' => 'required|integer|min_length(2)|max_length(3)',
            'email' => 'required|email',
        ]);

        $this->validate->setMessages([
            'name' => [
                'required' => 'The name field is required.'
            ],
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email address is not valid.'
            ],
            'age' => [
                'required' => 'The age field is required.',
                'integer' => 'The age must be an integer.',
                'min_length' => 'The age minimum length must 2.',
                'max_length' => 'The age maximum length must 3.'
            ]
        ]);
    }

    public function update(): void
    {
        if ($this->request->getMethod() === 'post') {
            if ( $this->validate->validateEntries($this->request->getBody()) ) {
                $model = new UserModel();
                $data = [
                    'name' => $this->request->getPost("name"),
                    'email' => $this->request->getPost("email"),
                    'age' => $this->request->getPost("age"),
                    'last_update' => date('Y-m-d H:i:s')
                ];

                if ($model->updateRecord($this->request->getPost("id"), $data)) {
                    /**
                    * Do your business here 
                    * $this->render("profile")->view(['userInfo' => $data]); Render view
                    * $this->redirect("/"); Redirect to main view or any view
                    */
                } else {
                    echo "Failed to update ";
                }
           }else{
               /**
                * Get the validation error information  
               */
                print_r($this->validate->getErrors());
           }
        }
    }

    public function profile($userId)
    {
        $model = new UserModel();
        $userInfo = $model->getRecord( $userId );
        if(empty($userInfo)){
            /**
             * Do your unknown business here
            */
            return;
        }
        $this->render("profile")->view(['userInfo' => $userInfo]);
    }
}
```

#### Input Validation Methods

With input validation Class, you can validate user submitted information before saving it to database.
To do that you will have to set validation rules for for each input field and optional error messages for the set rules.

In your controller class, once you extend `BaseController` and initialize it, you can use input validation and request.

Methods     |    Description 
------------|------------------------------------------------
validateEntries(array $input, array $rules = []): bool  | To validate input entries, it return true or false. The second parameter is optional.
validateField(string $ruleName, string $value, string $rule, ?string $param = null): bool  | To validate fields processed by `validateEntries` method it return true or false. The third parameter is optional
getErrors(): array | Get validation error messages 
setRules(array $rules, array $messages = []): self | Set validation rules with optional messages
addRule(string $field, string $rules, array $messages = []): self | Add validation rule with optional messages
setMessages(array $messages): self | Set validation messages
addMessage(string $field, array $messages): self | Add validation message to field

#### Input Validation Rules

To set validation rules you must septate each rule with a parenthesis and parameter in bracket notation.
Example 
```php
$this->validate->addRule('name', 'required|max_length(10)|alphanumeric')
```

Rule           | Parameter    | Description
---------------|--------------|------------------------------------------------
required       |  Void        | Field is required, it cannot be empty
max_length()   |  Integer     | Field maximum allowed length
min_length()   |  Integer     | Field minimum allowed length
alphanumeric   |  Void        | Field should must be only alphanumeric [aZ-Az-0-9]
email          |  Void        | Field should must be a valid email address
integer()      |  String      | Field should must an integer value, optional parameter [positive or negative] [-0-9]
equals()       |  String      | Field value must match with anther specified field value 
url            |  Void        | Field must be a valid URL
alphabet       |  Void        | Field must be only an alphabet [aZ-Az]
uuid()         |  Integer     | Field value must be uuid string, optional parameter for uuid version 
exact_length() |  Integer     | Field value must be exact length
ip()           |  Integer     | Field value must be a valid IP address, optional parameter for ip version
decimal        |  Void        | Field must be a valid decimal value
match()        |  Regex       | Field value must match the regular expression [/pattern/] 
fallback()     |  Mixed       | If the field value is empty, replace it withe the default value, if parameter is empty any empty string will be used instead




## DATABASE

#### Working With Database

To work with database depending on your use case, you can extent the `Query` class or `Conn` class.
Once you have setup the database configuration in your `.env` file.

Here are some examples 
#### Working Conn Class 

You can extend the `Conn` class or initialize the class to grab the connection instance `$conn = new Conn();`

```php 
namespace Luminova\Database;
use Luminova\Exceptions\DatabaseException;
use \Luminova\Cache\FileCache;

class MyConn extends Conn {  
    public function __construct(){
		parent::__construct();
	}

    public function update(string $name): int {
        $updateQuery = "UPDATE users SET name = :name";
        $this->db->prepare($updateQuery);
        $this->db->bind(":name", $name);
        $this->db->execute();
        return $this->db->rowCount()     
    }

    public function get(string $id): int {
        $updateQuery = "SELECT * FROM users WHERE uid = :uid LIMIT 1";
        $this->db->prepare($updateQuery);
        $this->db->bind(":uid", $id);
        $this->db->execute();
        return $this->db->getOne()     
    }
}
```

#### Working Query Class 

You can extend the `Query` class or initialize the class to grab the connection instance `$query = new Query();` or use the singleton instance `$query = Query::getInstance();`, depending on your use case 

```php 
namespace Luminova\Database;
use Luminova\Exceptions\DatabaseException;
use \Luminova\Cache\FileCache;

class MyQuery extends Query {  
    public function __construct(){
		parent::__construct();
	}

    public function updateData(string $name): int {
        return $this->table("user")->where("uid", 1)->update([
            "name" => $name
        ]);
    }

    public function getUser(string $id): int {
        return $this->table("user")->where("uid", $id)->find([
            "name", "email", "age"
        ]);    
    }
    public function getFriends(string $id): int {
        return $this->table("friends")->where("uid", $id)->and("friendListId", "myFriends")->select([
            "name", "email", "age"
        ]);    
    }
}
```

#### Query Class Method

Method                                |  Description
--------------------------------------|--------------------------
table(string $table): self            | Table name to query
join(string $table, string $type = "INNER"): self            | Table name to join
on(array $seeds): self  | Table join `ON` condition 
innerJoin(string $table): self  | Inner join, shorthand for join with second parameter
leftJoin(string $table): self | Left join, shorthand for join with second parameter
limit(int $offset = 0, int $count = 50): self  | Limit with offset and count
order(string $order): self  | Table sorting by order
group(string $group): self | Table grouping column by order
where(string $column, string $key): self  | table `WHERE` clause
and(string $column, string $key): self  | Table `AND` clause
set(string $column, mixed $value): self | Update table set value with column and value
or(string $column, string $key): self  | Table `OR` clause 
andOr(string $column, string $key, string $columnOr, string $keyOr): self  | Table `(AND OR)` clause
in(string $column, array $list): self | Find in List using `IN` selector 
inset(string $search, array $list, string $method = '='): self  | Find in set using `IN_SET` selector 
cache(string $storage, ?string $key = '', ?string $uid = '', int $expiry = 7 * 24 * 60 * 60): self  | Cache table response and return cache next time till expiration 
insert(array $values, bool $bind = true): int  | Insert into table. optional second parameter to use prepared statement or query execution
select(array $columns = ["*"]): mixed  | Retrieve records from table, optional parameter to specify columns
find(array $columns = ["*"]): mixed  | Retrieve one record from table, optional parameter to specify columns 
update(?array $sets = null): int  | Update table record. if you already used set method, then the second parameter is not required to set columns and values
delete(int $limit = 0): int | Delete all records from table with optional parameter to set limit
truncate(bool $transaction = true): bool | Truncate table to clear all records, optional parameter to set using transaction.
drop(): int   | Drop table
createTable(array $columns): int  | Create a new table 
create(Columns $column): int  | Create new table using column class 
withColumns() : Columns | Generate table columns and setups
