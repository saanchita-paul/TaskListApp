## Backend Description (REST API)



``` In this application user can register and then login.
    After login, it will generate a token and using this token user can login to the system . Then they can create task, edit task, delete task and also view task .
    - Here is two types of user role: admin and user. 
    - Both types of user can create, view, update and delete task lists.
    - Admin users can view, edit and delete all user’s tasks 
    
```

``` If any user do not logout then next time they can easily login in to the system with previous token. But if any user logout from the system then the token will removed and next time it will generate a new token.

``` 