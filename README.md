# Getting started

This is a sample server Petstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).  For this sample, you can use the api key `special-key` to test the authorization filters.

## How to Build

The generated code has dependencies over external libraries like UniRest. These dependencies are defined in the ```composer.json``` file that comes with the SDK. 
To resolve these dependencies, we use the Composer package manager which requires PHP greater than 5.3.2 installed in your system. 
Visit [https://getcomposer.org/download/](https://getcomposer.org/download/) to download the installer file for Composer and run it in your system. 
Open command prompt and type ```composer --version```. This should display the current version of the Composer installed if the installation was successful.

* Using command line, navigate to the directory containing the generated files (including ```composer.json```) for the SDK. 
* Run the command ```composer install```. This should install all the required dependencies and create the ```vendor``` directory in your project directory.

![Building SDK - Step 1](https://apidocs.io/illustration/php?step=installDependencies&workspaceFolder=Swagger%20Petstore-PHP)

### [For Windows Users Only] Configuring CURL Certificate Path in php.ini

CURL used to include a list of accepted CAs, but no longer bundles ANY CA certs. So by default it will reject all SSL certificates as unverifiable. You will have to get your CA's cert and point curl at it. The steps are as follows:

1. Download the certificate bundle (.pem file) from [https://curl.haxx.se/docs/caextract.html](https://curl.haxx.se/docs/caextract.html) on to your system.
2. Add curl.cainfo = "PATH_TO/cacert.pem" to your php.ini file located in your php installation. “PATH_TO” must be an absolute path containing the .pem file.

```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
;curl.cainfo =
```

## How to Use

The following section explains how to use the SwaggerPetstore library in a new project.

### 1. Open Project in an IDE

Open an IDE for PHP like PhpStorm. The basic workflow presented here is also applicable if you prefer using a different editor or IDE.

![Open project in PHPStorm - Step 1](https://apidocs.io/illustration/php?step=openIDE&workspaceFolder=Swagger%20Petstore-PHP)

Click on ```Open``` in PhpStorm to browse to your generated SDK directory and then click ```OK```.

![Open project in PHPStorm - Step 2](https://apidocs.io/illustration/php?step=openProject0&workspaceFolder=Swagger%20Petstore-PHP)     

### 2. Add a new Test Project

Create a new directory by right clicking on the solution name as shown below:

![Add a new project in PHPStorm - Step 1](https://apidocs.io/illustration/php?step=createDirectory&workspaceFolder=Swagger%20Petstore-PHP)

Name the directory as "test"

![Add a new project in PHPStorm - Step 2](https://apidocs.io/illustration/php?step=nameDirectory&workspaceFolder=Swagger%20Petstore-PHP)
   
Add a PHP file to this project

![Add a new project in PHPStorm - Step 3](https://apidocs.io/illustration/php?step=createFile&workspaceFolder=Swagger%20Petstore-PHP)

Name it "testSDK"

![Add a new project in PHPStorm - Step 4](https://apidocs.io/illustration/php?step=nameFile&workspaceFolder=Swagger%20Petstore-PHP)

Depending on your project setup, you might need to include composer's autoloader in your PHP code to enable auto loading of classes.

```PHP
require_once "../vendor/autoload.php";
```

It is important that the path inside require_once correctly points to the file ```autoload.php``` inside the vendor directory created during dependency installations.

![Add a new project in PHPStorm - Step 4](https://apidocs.io/illustration/php?step=projectFiles&workspaceFolder=Swagger%20Petstore-PHP)

After this you can add code to initialize the client library and acquire the instance of a Controller class. Sample code to initialize the client library and using controller methods is given in the subsequent sections.

### 3. Run the Test Project

To run your project you must set the Interpreter for your project. Interpreter is the PHP engine installed on your computer.

Open ```Settings``` from ```File``` menu.

![Run Test Project - Step 1](https://apidocs.io/illustration/php?step=openSettings&workspaceFolder=Swagger%20Petstore-PHP)

Select ```PHP``` from within ```Languages & Frameworks```

![Run Test Project - Step 2](https://apidocs.io/illustration/php?step=setInterpreter0&workspaceFolder=Swagger%20Petstore-PHP)

Browse for Interpreters near the ```Interpreter``` option and choose your interpreter.

![Run Test Project - Step 3](https://apidocs.io/illustration/php?step=setInterpreter1&workspaceFolder=Swagger%20Petstore-PHP)

Once the interpreter is selected, click ```OK```

![Run Test Project - Step 4](https://apidocs.io/illustration/php?step=setInterpreter2&workspaceFolder=Swagger%20Petstore-PHP)

To run your project, right click on your PHP file inside your Test project and click on ```Run```

![Run Test Project - Step 5](https://apidocs.io/illustration/php?step=runProject&workspaceFolder=Swagger%20Petstore-PHP)

## How to Test

Unit tests in this SDK can be run using PHPUnit. 

1. First install the dependencies using composer including the `require-dev` dependencies.
2. Run `vendor\bin\phpunit --verbose` from commandline to execute tests. If you have 
   installed PHPUnit globally, run tests using `phpunit --verbose` instead.

You can change the PHPUnit test configuration in the `phpunit.xml` file.

## Initialization

### Authentication
In order to setup authentication and initialization of the API client, you need the following information.

| Parameter | Description |
|-----------|-------------|
| oAuthClientId | OAuth 2 Client ID |
| oAuthRedirectUri | OAuth 2 Redirection endpoint or Callback Uri |



API client can be initialized as following.

```php
$oAuthClientId = 'oAuthClientId'; // OAuth 2 Client ID
$oAuthRedirectUri = 'https://example.com/oauth/callback'; // OAuth 2 Redirection endpoint or Callback Uri

$client = new SwaggerPetstoreLib\SwaggerPetstoreClient($oAuthClientId, $oAuthRedirectUri);
```

You must authorize now authorize the client.

### Authorizing your client

Your application must obtain user authorization before it can execute an endpoint call.
The SDK uses *OAuth 2.0 Implicit Grant* to obtain a user's consent to perform an API request on user's behalf.

This process requires the presence of a client-side JavaScript code on the redirect URI page to 
receive the *access token* after the consent step is completed.

#### 1. Obtain consent

To obtain user's consent, you must redirect the user to the authorization page.
The `buildAuthorizationUrl()` method creates the URL to the authorization page.
 You must pass the *[scopes](#scopes)* for which you need permission to access.
```php
$authUrl = $client->auth()->buildAuthorizationUrl([OAuthScopeEnum::READPETS, OAuthScopeEnum::WRITEPETS]);
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
```

#### 2. Handle the OAuth server response

Once the user responds to the consent request, the OAuth 2.0 server responds to your application's access request by redirecting the user to the redirect URI specified set in `Configuration`.

The redirect URI will receive the *access token* as the `access_token` argument in the URL fragment.

```
https://example.com/oauth/callback#access_token=XXXXXXXXXXXXXXXXXXXXXXXXX
```

The access token must be extracted by the client-side JavaScript code. The access token can be used to authorize any further endpoint calls by the JavaScript code.

### Scopes

Scopes enable your application to only request access to the resources it needs while enabling users to control the amount of access they grant to your application. Available scopes are defined in the `SwaggerPetstoreLib\Models\OAuthScopeEnum` enumeration.

| Scope Name | Description |
| --- | --- |
| `READPETS` | read your pets |
| `WRITEPETS` | modify pets in your account |



# Class Reference

## <a name="list_of_controllers"></a>List of Controllers

* [PetController](#pet_controller)
* [StoreController](#store_controller)
* [UserController](#user_controller)

## <a name="pet_controller"></a>![Class: ](https://apidocs.io/img/class.png ".PetController") PetController

### Get singleton instance

The singleton instance of the ``` PetController ``` class can be accessed from the API Client.

```php
$pet = $client->getPet();
```

### <a name="upload_file"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.uploadFile") uploadFile

> uploads an image


```php
function uploadFile(
        $petId,
        $additionalMetadata = null,
        $file = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| petId |  ``` Required ```  | ID of pet to update |
| additionalMetadata |  ``` Optional ```  | Additional data to pass to server |
| file |  ``` Optional ```  | file to upload |



#### Example Usage

```php
$petId = 245;
$additionalMetadata = 'additionalMetadata';
$file = "PathToFile";

$result = $pet->uploadFile($petId, $additionalMetadata, $file);

```


### <a name="add_pet"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.addPet") addPet

> Add a new pet to the store


```php
function addPet($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | Pet object that needs to be added to the store |



#### Example Usage

```php
$body = new Pet();

$pet->addPet($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 405 | Invalid input |



### <a name="update_pet"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.updatePet") updatePet

> Update an existing pet


```php
function updatePet($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | Pet object that needs to be added to the store |



#### Example Usage

```php
$body = new Pet();

$pet->updatePet($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid ID supplied |
| 404 | Pet not found |
| 405 | Validation exception |



### <a name="find_pets_by_status"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.findPetsByStatus") findPetsByStatus

> Multiple status values can be provided with comma separated strings


```php
function findPetsByStatus($status)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| status |  ``` Required ```  ``` Collection ```  | Status values that need to be considered for filter |



#### Example Usage

```php
$status = array(status2::AVAILABLE);

$result = $pet->findPetsByStatus($status);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid status value |



### <a name="find_pets_by_tags"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.findPetsByTags") findPetsByTags

> Multiple tags can be provided with comma separated strings. Use tag1, tag2, tag3 for testing.


```php
function findPetsByTags($tags)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| tags |  ``` Required ```  ``` Collection ```  | Tags to filter by |



#### Example Usage

```php
$tags = array('tags');

$result = $pet->findPetsByTags($tags);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid tag value |



### <a name="get_pet_by_id"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.getPetById") getPetById

> Returns a single pet


```php
function getPetById($petId)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| petId |  ``` Required ```  | ID of pet to return |



#### Example Usage

```php
$petId = 245;

$result = $pet->getPetById($petId);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid ID supplied |
| 404 | Pet not found |



### <a name="update_pet_with_form"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.updatePetWithForm") updatePetWithForm

> Updates a pet in the store with form data


```php
function updatePetWithForm(
        $petId,
        $name = null,
        $status = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| petId |  ``` Required ```  | ID of pet that needs to be updated |
| name |  ``` Optional ```  | Updated name of the pet |
| status |  ``` Optional ```  | Updated status of the pet |



#### Example Usage

```php
$petId = 245;
$name = 'name';
$status = 'status';

$pet->updatePetWithForm($petId, $name, $status);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 405 | Invalid input |



### <a name="delete_pet"></a>![Method: ](https://apidocs.io/img/method.png ".PetController.deletePet") deletePet

> Deletes a pet


```php
function deletePet(
        $petId,
        $apiKey = null)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| petId |  ``` Required ```  | Pet id to delete |
| apiKey |  ``` Optional ```  | TODO: Add a parameter description |



#### Example Usage

```php
$petId = 245;
$apiKey = 'api_key';

$pet->deletePet($petId, $apiKey);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid ID supplied |
| 404 | Pet not found |



[Back to List of Controllers](#list_of_controllers)

## <a name="store_controller"></a>![Class: ](https://apidocs.io/img/class.png ".StoreController") StoreController

### Get singleton instance

The singleton instance of the ``` StoreController ``` class can be accessed from the API Client.

```php
$store = $client->getStore();
```

### <a name="create_place_order"></a>![Method: ](https://apidocs.io/img/method.png ".StoreController.createPlaceOrder") createPlaceOrder

> Place an order for a pet


```php
function createPlaceOrder($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | order placed for purchasing the pet |



#### Example Usage

```php
$body = new Order();

$result = $store->createPlaceOrder($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid Order |



### <a name="get_order_by_id"></a>![Method: ](https://apidocs.io/img/method.png ".StoreController.getOrderById") getOrderById

> For valid response try integer IDs with value >= 1 and <= 10. Other values will generated exceptions


```php
function getOrderById($orderId)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| orderId |  ``` Required ```  | ID of pet that needs to be fetched |



#### Example Usage

```php
$orderId = 245;

$result = $store->getOrderById($orderId);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid ID supplied |
| 404 | Order not found |



### <a name="delete_order"></a>![Method: ](https://apidocs.io/img/method.png ".StoreController.deleteOrder") deleteOrder

> For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors


```php
function deleteOrder($orderId)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| orderId |  ``` Required ```  | ID of the order that needs to be deleted |



#### Example Usage

```php
$orderId = 245;

$store->deleteOrder($orderId);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid ID supplied |
| 404 | Order not found |



### <a name="get_inventory"></a>![Method: ](https://apidocs.io/img/method.png ".StoreController.getInventory") getInventory

> Returns a map of status codes to quantities


```php
function getInventory()
```

#### Example Usage

```php

$result = $store->getInventory();

```


[Back to List of Controllers](#list_of_controllers)

## <a name="user_controller"></a>![Class: ](https://apidocs.io/img/class.png ".UserController") UserController

### Get singleton instance

The singleton instance of the ``` UserController ``` class can be accessed from the API Client.

```php
$user = $client->getUser();
```

### <a name="create_users_with_array_input"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.createUsersWithArrayInput") createUsersWithArrayInput

> Creates list of users with given input array


```php
function createUsersWithArrayInput($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  ``` Collection ```  | List of user object |



#### Example Usage

```php
$user = new User();
$body = array($user);

$user->createUsersWithArrayInput($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 0 | successful operation |



### <a name="create_users_with_list_input"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.createUsersWithListInput") createUsersWithListInput

> Creates list of users with given input array


```php
function createUsersWithListInput($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  ``` Collection ```  | List of user object |



#### Example Usage

```php
$user = new User();
$body = array($user);

$user->createUsersWithListInput($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 0 | successful operation |



### <a name="get_user_by_name"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.getUserByName") getUserByName

> Get user by user name


```php
function getUserByName($username)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| username |  ``` Required ```  | The name that needs to be fetched. Use user1 for testing. |



#### Example Usage

```php
$username = 'username';

$result = $user->getUserByName($username);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid username supplied |
| 404 | User not found |



### <a name="update_user"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.updateUser") updateUser

> This can only be done by the logged in user.


```php
function updateUser(
        $username,
        $body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| username |  ``` Required ```  | name that need to be updated |
| body |  ``` Required ```  | Updated user object |



#### Example Usage

```php
$username = 'username';
$body = new User();

$user->updateUser($username, $body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid user supplied |
| 404 | User not found |



### <a name="delete_user"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.deleteUser") deleteUser

> This can only be done by the logged in user.


```php
function deleteUser($username)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| username |  ``` Required ```  | The name that needs to be deleted |



#### Example Usage

```php
$username = 'username';

$user->deleteUser($username);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid username supplied |
| 404 | User not found |



### <a name="get_login_user"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.getLoginUser") getLoginUser

> Logs user into the system


```php
function getLoginUser(
        $username,
        $password)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| username |  ``` Required ```  | The user name for login |
| password |  ``` Required ```  | The password for login in clear text |



#### Example Usage

```php
$username = 'username';
$password = 'password';

$result = $user->getLoginUser($username, $password);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 400 | Invalid username/password supplied |



### <a name="get_logout_user"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.getLogoutUser") getLogoutUser

> Logs out current logged in user session


```php
function getLogoutUser()
```

#### Example Usage

```php

$user->getLogoutUser();

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 0 | successful operation |



### <a name="create_user"></a>![Method: ](https://apidocs.io/img/method.png ".UserController.createUser") createUser

> This can only be done by the logged in user.


```php
function createUser($body)
```

#### Parameters

| Parameter | Tags | Description |
|-----------|------|-------------|
| body |  ``` Required ```  | Created user object |



#### Example Usage

```php
$body = new User();

$user->createUser($body);

```

#### Errors

| Error Code | Error Description |
|------------|-------------------|
| 0 | successful operation |



[Back to List of Controllers](#list_of_controllers)



