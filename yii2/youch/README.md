Documentation
===============================
API Url: http://api.youch.me/  
Content-Type: application/json  

[TOC]

Authorization
-------------------------------
http://api.youch.me/oauth2/token  
Method: POST  
Params:  
```
{
    "grant_type": "password",
    "username": "username",
    "password": "password",
    "client_id": "testclient",
    "client_secret": "testpass"
}
```
Answer without errors:  
```
{
    "access_token": "d5bf9c2c22efd84d560adf4cbe4807802efbefa8",
    "expires_in": 86400,
    "token_type": "Bearer",
    "scope": null,
    "refresh_token": "99787116a9a1fa01a24c6be6a14d019108f0de16"
}
```
Possible errors:  
```
{
    "name": "Bad Request"
    "message": "Grant type "password" not supported"
    "code": 0
    "status": 400
    "type": "filsh\yii2\oauth2server\exceptions\HttpException"
}

{
    "name": "Bad Request"
    "message": "The client credentials are invalid"
    "code": 0
    "status": 400
    "type": "filsh\yii2\oauth2server\exceptions\HttpException"
}

{
    "name": "Unauthorized"
    "message": "Invalid username and password combination"
    "code": 0
    "status": 401
    "type": "filsh\yii2\oauth2server\exceptions\HttpException"
}

{
    "name": "Bad Request"
    "message": "Missing parameters: "username" and "password" required"
    "code": 0
    "status": 400
    "type": "filsh\yii2\oauth2server\exceptions\HttpException"
}
```

Refresh Token
-------------------------------
http://api.youch.me/oauth2/token  
Method: POST  
Params:  
```
{
    "grant_type": "refresh_token",
    "refresh_token": "your_token",
    "client_id": "testclient",
    "client_secret": "testpass"
}
```
Answer without errors:  
```
{
    "access_token": "d5bf9c2c22efd84d560adf4cbe4807802efbefa8",
    "expires_in": 86400,
    "token_type": "Bearer",
    "scope": null,
    "refresh_token": "99787116a9a1fa01a24c6be6a14d019108f0de16"
}
```

Registration
===============================
Step 1
-------------------------------
http://api.youch.me/register/step1  
Method: POST  
Params:  
```
{
    "first_name": "First names",
    "last_name": "Last name",
    "email": "email",
    "role": "tourist | company"
    "password": "password", // minLength => 6
    "confirm_password": "confirm_password"
}
```
Answer without errors:  
```
{
    "access_token": "d5bf9c2c22efd84d560adf4cbe4807802efbefa8",
    "expires_in": 86400,
    "token_type": "Bearer",
    "scope": null,
    "refresh_token": "99787116a9a1fa01a24c6be6a14d019108f0de16"
}
```

Step 2 (need Authorization header with access_token from step 1)
-------------------------------
http://api.youch.me/register/step2  
Method: POST  
Params:  
```
{
    "username": "User Login",
}
```
Answer without errors:  
```
{
    "id": 1,
    "username": "User Login",
    "auth_key": "CyiLRThXu5UOwcQhISKiYAg-XXaazTAB",
    "password_hash": "$2y$13$DUfc2kZAqkfgd9Hhqqy27.ZRE8YrxYEgRxkMTj9aMVN5gZBO.vQbm",
    "password_reset_token": "wizZKMn495YYG0FfKcVEXgfXUR2yvC6c_1492259103",
    "email": "ramzes.2007.90@gmail.com",
    "status": 10,
    "created_at": 1492259103,
    "updated_at": 1492260639,
    "first_name": "Roman",
    "last_name": "Lukoyanov",
    "about": null,
    "city_id": null
}
```

Step 3 (need Authorization header with access_token from step 1)
-------------------------------
http://api.youch.me/register/step3  
Method: POST  
Params:  
```
{
    "name":"Нижний Новгород, Россия",
    "city":"Нижний Новгород",
    "id":"asdashfakjslhfakjslhf",
    "lat":52.3,
    "long":26.5
}   
```
Answer without errors:  
```
{
    "id": 1,
    "username": "User Login",
    "auth_key": "CyiLRThXu5UOwcQhISKiYAg-XXaazTAB",
    "password_hash": "$2y$13$DUfc2kZAqkfgd9Hhqqy27.ZRE8YrxYEgRxkMTj9aMVN5gZBO.vQbm",
    "password_reset_token": "wizZKMn495YYG0FfKcVEXgfXUR2yvC6c_1492259103",
    "email": "ramzes.2007.90@gmail.com",
    "status": 10,
    "created_at": 1492259103,
    "updated_at": 1492260639,
    "name": "Roman Lukoyanov",
    "about": null,
    "city_id": 3
}
```

Step 4 (need Authorization header with access_token from step 1)
-------------------------------
http://api.youch.me/register/step4  
Method: POST  
Params:  
```
{
    "about": "Tell about yourself!",
}
```
Answer without errors:  
```
{
    "id": 1,
    "username": "User Login",
    "auth_key": "CyiLRThXu5UOwcQhISKiYAg-XXaazTAB",
    "password_hash": "$2y$13$DUfc2kZAqkfgd9Hhqqy27.ZRE8YrxYEgRxkMTj9aMVN5gZBO.vQbm",
    "password_reset_token": "wizZKMn495YYG0FfKcVEXgfXUR2yvC6c_1492259103",
    "email": "ramzes.2007.90@gmail.com",
    "status": 10,
    "created_at": 1492259103,
    "updated_at": 1492260639,
    "name": "Roman Lukoyanov",
    "about": "Tell about yourself!",
    "city_id": 3
}
```

Password recovery
===============================
Reset pass
-------------------------------
http://api.youch.me/auth/reset  
Method: POST  
Params:  
```
{
    "email": "email",
}
```
Answer without errors:  
```
{
    "msg": "Instructions was sent to the email."
}
```

User Profile  
===============================
Get profile  
-------------------------------
http://api.youch.me/user/profile  
Method: GET  
Params: Authorization Header  
Answer without errors:  
```
{
    "id": 2,
    "username": "admin",
    "email": "admin@youch.me",
    "first_name": "Roman",
    "last_name": "Lukoyanov",
    "state": "active",
    "site": "http://youch.me/",
    "avatar": null,
    "get_messages": null,
    "hide_events": null,
    "birthday": "1990-10-28",
    "about": "Romashka!!!",
    "city": {
        "name": "Нижний Новгород, Россия",
        "city": "Нижний Новгород",
        "google_id": "asdashfakjslhfakjslhf",
        "lat": 52.3,
        "lng": 26.5
    }
}
```

Get profile by username  
-------------------------------
http://api.youch.me/user/get/<username>  
Method: GET  
Answer without errors:  
```
{
    "id": 2,
    "username": "admin",
    "email": "admin@youch.me",
    "first_name": "Roman",
    "last_name": "Lukoyanov",
    "state": "active",
    "site": "http://youch.me/",
    "avatar": null,
    "get_messages": true | false,
    "hide_events": true | false,
    "birthday": "1990-10-28",
    "about": "Romashka!!!",
    "city": {
        "name": "Нижний Новгород, Россия",
        "city": "Нижний Новгород",
        "google_id": "asdashfakjslhfakjslhf",
        "lat": 52.3,
        "lng": 26.5
    }
}
```

Change personal settings  
-------------------------------
http://api.youch.me/user/change-profile  
Method: POST  
Params: Authorization Header  
```
{
    "email": "admin@youch.me",
    "username": "admin",
    "site": "http://youch.me/",
    "first_name": "Roman",
    "last_name": "Lukoyanov",
    "birthday": "1990-10-28",
    "about": "Romashka!!!",
    "city": {
        "name":"Нижний Новгород, Россия",
        "city":"Нижний Новгород",
        "id":"asdashfakjslhfakjslhf",
        "lat":52.3,
        "long":26.5
    }
}
```
Answer without errors: User object 

Change password  
-------------------------------
http://api.youch.me/user/change-password  
Method: POST  
Params: Authorization Header  
```
{
    "old_password": "old_password",
    "password": "new_password", // minLength => 6
    "confirm_password": "confirm_new_password"
}
```
Answer without errors: User object  

Change notifications  
-------------------------------
http://api.youch.me/user/change-alerts  
Method: POST  
Params: Authorization Header  
```
{
    "get_messages": true,
    "hide_events": false
}
```
Answer without errors: User object  

Get black list  
-------------------------------
http://api.youch.me/user/black-list  
Method: GET  
Params: Authorization Header  
Answer without errors:  
```
[
    {
        "id": 1,
        "user": null,
        "blocked": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "user": null,
        "blocked": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Get black list by username  
-------------------------------
http://api.youch.me/subscription/black-list/<username>  
Method: GET  
Answer without errors:  
```
[
    {
        "id": 1,
        "user": null,
        "blocked": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "user": null,
        "blocked": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Get followers  
-------------------------------
http://api.youch.me/user/followers  
Method: GET  
Params: Authorization Header  
Answer without errors:  
```
[
    {
        "id": 1,
        "follower": null,
        "user": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "follower": null,
        "user": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Get followers  by username  
-------------------------------
http://api.youch.me/subscription/followers/<username>  
Method: GET  
Answer without errors:  
```
[
    {
        "id": 1,
        "follower": null,
        "user": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "follower": null,
        "user": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Get followings  
-------------------------------
http://api.youch.me/user/followings  
Method: GET  
Params: Authorization Header  
Answer without errors:  
```
[
    {
        "id": 1,
        "user": null,
        "follower": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "user": null,
        "blocked": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Get followings by username  
-------------------------------
http://api.youch.me/subscription/followings/<username>  
Method: GET  
Answer without errors:  
```
[
    {
        "id": 1,
        "user": null,
        "follower": {
            "id": 6,
            "username": "RamZEWS",
            "email": "ramzes.2007.90@gmail.com",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": "Блондинчик!",
            "city": {
                "name": "Брест, Беларусь",
                "city": "Брест",
                "google_id": null,
                "lat": 52,
                "lng": 23
            }
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    {
        "id": 2,
        "user": null,
        "blocked": {
            "id": 4,
            "username": "user",
            "email": "user@youch.me",
            "first_name": null,
            "last_name": null,
            "state": "active",
            "site": null,
            "avatar": null,
            "get_messages": null,
            "hide_events": null,
            "birthday": null,
            "about": null,
            "city": null
        },
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```  

Set avatar  
-------------------------------
http://api.youch.me/user/avatar  
Method: POST  
Params: form data with name=file  
extensions => gif, jpg, png, jpeg  
Answer without errors: User object  

Remove avatar  
-------------------------------
http://api.youch.me/user/delete-avatar  
Method: POST  
Params: no params   
Answer without errors: User object 


Remove profile
-------------------------------
http://api.youch.me/user/delete  
Method: DELETE  
Params: Authorization Header  
Answer without errors:  true | false

Get all comments
-------------------------------
http://api.youch.me/user/all-comments  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

Get my comments
-------------------------------
http://api.youch.me/user/my-comments  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

Get comments to my all events
-------------------------------
http://api.youch.me/user/to-me-comments  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

Get comments to my contents  
-------------------------------
http://api.youch.me/user/to-my-contents  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

Get comments to my tours  
-------------------------------
http://api.youch.me/user/to-my-tours  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Tour object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Tour object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```

Get comments by username
-------------------------------
http://api.youch.me/comment/user/<username>  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

Get comments to username events
-------------------------------
http://api.youch.me/comment/to-user/<username>  
Method: GET  
Params: Authorization Header
Answer without errors:
```
[
    {
        "id": 7,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657322,
        "updated_at": 1493657322
    },
    {
        "id": 6,
        "content": {...Content object...},
        "user": {...User object...},
        "comment": "123123213213",
        "created_at": 1493657303,
        "updated_at": 1493657303
    }
]
```  

User contents  
-------------------------------
http://api.youch.me/user/content  
Method: GET  
Params: Authorization Header  
Answer without errors: List of Content Objects  

User tours  
-------------------------------
http://api.youch.me/user/tour  
Method: GET  
Params: Authorization Header   
Answer without errors: List of Tour Objects  

User events (by user role)  
-------------------------------
http://api.youch.me/user/my-events  
Method: GET  
Params: Authorization Header   
Answer without errors: List of Content or Tour Objects  

User events by username (by user role)  
-------------------------------
http://api.youch.me/event/<username>  
Method: GET  
Params: Authorization Header   
Answer without errors: List of Content or Tour Objects  

Cities  
===============================
Get Cities  
-------------------------------
http://api.youch.me/city  
Method: GET  
Answer without errors:  
```
[
    {
        "name": "Брест, Беларусь",
        "city": "Брест",
        "google_id": "dasdaskalkshkaj",
        "lat": 52,
        "lng": 23
    },
    {
        "name": "Нижний Новгород, Россия",
        "city": "Нижний Новгород",
        "google_id": "asdashfakjslhfakjslhf",
        "lat": 52.3,
        "lng": 26.5
    }
]
```

Get City
-------------------------------
http://api.youch.me/city/<city_id>  
Method: GET  
Answer without errors:  
```
{
    "name": "Нижний Новгород, Россия",
    "city": "Нижний Новгород",
    "google_id": "asdashfakjslhfakjslhf",
    "lat": 52.3,
    "lng": 26.5
}
```

Content  
===============================
Get Content List  
-------------------------------
http://api.youch.me/content/?category_id=1&page=1&perpage=10  
Method: GET  

category_id is not required
page is not required (default 1)
perpage is not required (default 10)  

Answer without errors:  
```
[
    {
        "id": 12,
        "title": "New Content",
        "description": "New Desc",
        "user": {
            "id": 2,
            "username": "admin",
            "email": "admin@youch.me",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": "http://youch.me/",
            "avatar": null,
            "get_messages": 1,
            "hide_events": 0,
            "birthday": "1990-10-28",
            "about": "Romashka!!!",
            "city": {
                "name": "Нижний Новгород, Россия",
                "city": "Нижний Новгород",
                "google_id": "asdashfakjslhfakjslhf",
                "lat": 52.3,
                "lng": 26.5
            }
        },
        "categories": [
            {
                "id": 1,
                "name_ru": "Туризм",
                "name_en": "Tourism",
                "created_at": 1492885673,
                "updated_at": 1492885673
            },
            {
                "id": 2,
                "name_ru": "Европа",
                "name_en": "Europe",
                "created_at": 1492885673,
                "updated_at": 1492885673
            }
        ],
        "days": {
            "mon": {
                "from": "09:00",
                "to": "21:00"
            },
            "tue": {
                "from": "09:00",
                "to": "21:00"
            }
        },
        "price_from": 200.02,
        "price_to": 201.02,
        "is_free": true / false,
        "is_tour": true / false,
        "date_from": "2017-11-12 12:12:12",
        "date_to": "2017-12-12 12:12:12",
        "site": "http://yandex.ru/",
        "phone": "89047946559",
        "city": {
            "name": "Брест, Беларусь",
            "city": "Брест",
            "google_id": null,
            "lat": 52,
            "lng": 23
        },
        "state": "active",
        "file": null,
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```

Get Content
-------------------------------
http://api.youch.me/content/<content_id>
Method: GET  
Answer without errors:  
```
{
    "id": 12,
    "title": "New Content",
    "description": "New Desc",
    "user": {
        "id": 2,
        "username": "admin",
        "email": "admin@youch.me",
        "first_name": "Roman",
        "last_name": "Lukoyanov",
        "state": "active",
        "site": "http://youch.me/",
        "avatar": null,
        "get_messages": 1,
        "hide_events": 0,
        "birthday": "1990-10-28",
        "about": "Romashka!!!",
        "city": {
            "name": "Нижний Новгород, Россия",
            "city": "Нижний Новгород",
            "google_id": "asdashfakjslhfakjslhf",
            "lat": 52.3,
            "lng": 26.5
        }
    },
    "categories": [
        {
            "id": 1,
            "name_ru": "Туризм",
            "name_en": "Tourism",
            "created_at": 1492885673,
            "updated_at": 1492885673
        },
        {
            "id": 2,
            "name_ru": "Европа",
            "name_en": "Europe",
            "created_at": 1492885673,
            "updated_at": 1492885673
        }
    ],
    "days": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:00",
            "to": "21:00"
        }
    },
    "price_from": 200.02,
    "price_to": 201.02,
    "is_free": true / false,
    "is_tour": true / false,
    "date_from": "2017-11-12 12:12:12",
    "date_to": "2017-12-12 12:12:12",
    "site": "http://yandex.ru/",
    "phone": "89047946559",
    "city": {
        "name": "Брест, Беларусь",
        "city": "Брест",
        "google_id": null,
        "lat": 52,
        "lng": 23
    },
    "state": "active",
    "file": null,
    "created_at": 1492885673,
    "updated_at": 1492885673
}
```

Get User Content List
-------------------------------
http://api.youch.me/content/user/<username>  
Method: GET  
Answer without errors:  
```
[
    {
        "id": 12,
        "title": "New Content",
        "description": "New Desc",
        "user": {
            "id": 2,
            "username": "admin",
            "email": "admin@youch.me",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": "http://youch.me/",
            "avatar": null,
            "get_messages": 1,
            "hide_events": 0,
            "birthday": "1990-10-28",
            "about": "Romashka!!!",
            "city": {
                "name": "Нижний Новгород, Россия",
                "city": "Нижний Новгород",
                "google_id": "asdashfakjslhfakjslhf",
                "lat": 52.3,
                "lng": 26.5
            }
        },
        "categories": [
            {
                "id": 1,
                "name_ru": "Туризм",
                "name_en": "Tourism",
                "created_at": 1492885673,
                "updated_at": 1492885673
            },
            {
                "id": 2,
                "name_ru": "Европа",
                "name_en": "Europe",
                "created_at": 1492885673,
                "updated_at": 1492885673
            }
        ],
        "days": {
            "mon": {
                "from": "09:00",
                "to": "21:00"
            },
            "tue": {
                "from": "09:00",
                "to": "21:00"
            }
        },
        "price_from": 200.02,
        "price_to": 201.02,
        "is_free": true / false,
        "is_tour": true / false,
        "date_from": "2017-11-12 12:12:12",
        "date_to": "2017-12-12 12:12:12",
        "site": "http://yandex.ru/",
        "phone": "89047946559",
        "city": {
            "name": "Брест, Беларусь",
            "city": "Брест",
            "google_id": null,
            "lat": 52,
            "lng": 23
        },
        "state": "active",
        "file": null,
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```

Create Content
-------------------------------
http://api.youch.me/content/save  
Method: POST  
Params:  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
```
{
    "title": "Pass2",
    "description": "ALALA!2",
    "price_from": 10.05,
    "price_to": 205.5,
    "is_free": true / false,
    "date_from": "2017-04-12", // date format Y-m-d
    "date_to": "2017-05-20", // date format Y-m-d
    "time_from": "09:00", // string
    "time_to": "21:00", // string
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "city": {
        "city": "Брест",
        "name": "Брест, Беларусь",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Content Object  

Update Content
-------------------------------
http://api.youch.me/content/save  
Method: POST  
Params:  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
```
{
    "id": 14,
    "title": "Pass2",
    "description": "ALALA!2",
    "price_from": 10.05,
    "price_to": 205.5,
    "is_free": true / false,
    "date_from": "2017-04-12", // date format Y-m-d
    "date_to": "2017-05-20", // date format Y-m-d
    "time_from": "09:00", // string
    "time_to": "21:00", // string
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "city": {
        "city": "Брест",
        "name": "Брест, Беларусь",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Content Object  

Get Comments
-------------------------------
http://api.youch.me/content/get-comments?id=<content_id>&page=1&perpage=10  
Method: GET
  
id is required  
page is not required (default 1)  
perpage is not required (default 10)  
  
Params:  
```
{

}
```  
Answer without errors: Content comment list

Add Comment
-------------------------------
http://api.youch.me/content/add-comment  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "comment": "ALALALALA!"
}
```  
Answer without errors: Content comment list    

Add Mark
-------------------------------
http://api.youch.me/content/add-mark  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "rating": 3
}
```  
Answer without errors: Content Object  

Set Image
-------------------------------
http://api.youch.me/content/image?id=<content_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Content Object  

Delete Image
-------------------------------
http://api.youch.me/content/delete-image?id=<content_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Content Object 

Tours  
===============================
Get tour List  
-------------------------------
http://api.youch.me/tour/?category_id=1&page=1&perpage=10  
Method: GET  

category_id is not required
page is not required (default 1)
perpage is not required (default 10)  

Answer without errors:  
```
[
    {
        "id": 12,
        "title": "New Content",
        "description": "New Desc",
        "user": {
            "id": 2,
            "username": "admin",
            "email": "admin@youch.me",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": "http://youch.me/",
            "avatar": null,
            "get_messages": 1,
            "hide_events": 0,
            "birthday": "1990-10-28",
            "about": "Romashka!!!",
            "city": {
                "name": "Нижний Новгород, Россия",
                "city": "Нижний Новгород",
                "google_id": "asdashfakjslhfakjslhf",
                "lat": 52.3,
                "lng": 26.5
            }
        },
        "categories": [
            {
                "id": 1,
                "name_ru": "Туризм",
                "name_en": "Tourism",
                "created_at": 1492885673,
                "updated_at": 1492885673
            },
            {
                "id": 2,
                "name_ru": "Европа",
                "name_en": "Europe",
                "created_at": 1492885673,
                "updated_at": 1492885673
            }
        ],
        "days": {
            "mon": {
                "from": "09:00",
                "to": "21:00"
            },
            "tue": {
                "from": "09:00",
                "to": "21:00"
            }
        },
        "price_from": 200.02,
        "price_to": 201.02,
        "is_free": true / false,
        "is_tour": true / false,
        "date_from": "2017-11-12 12:12:12",
        "date_to": "2017-12-12 12:12:12",
        "site": "http://yandex.ru/",
        "phone": "89047946559",
        "city": {
            "name": "Брест, Беларусь",
            "city": "Брест",
            "google_id": null,
            "lat": 52,
            "lng": 23
        },
        "state": "active",
        "file": null,
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```

Get Tour
-------------------------------
http://api.youch.me/tour/<tour_id>
Method: GET  
Answer without errors:  
```
{
    "id": 12,
    "title": "New Content",
    "description": "New Desc",
    "user": {
        "id": 2,
        "username": "admin",
        "email": "admin@youch.me",
        "first_name": "Roman",
        "last_name": "Lukoyanov",
        "state": "active",
        "site": "http://youch.me/",
        "avatar": null,
        "get_messages": 1,
        "hide_events": 0,
        "birthday": "1990-10-28",
        "about": "Romashka!!!",
        "city": {
            "name": "Нижний Новгород, Россия",
            "city": "Нижний Новгород",
            "google_id": "asdashfakjslhfakjslhf",
            "lat": 52.3,
            "lng": 26.5
        }
    },
    "category": {
        "id": 1,
        "name_ru": "Туризм",
        "name_en": "Tourism",
        "created_at": 1492885673,
        "updated_at": 1492885673
    },
    "days": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:00",
            "to": "21:00"
        }
    },
    "price_from": 200.02,
    "price_to": 201.02,
    "is_free": true / false,
    "is_tour": true / false,
    "date_from": "2017-11-12 12:12:12",
    "date_to": "2017-12-12 12:12:12",
    "site": "http://yandex.ru/",
    "phone": "89047946559",
    "city": {
        "name": "Брест, Беларусь",
        "city": "Брест",
        "google_id": null,
        "lat": 52,
        "lng": 23
    },
    "state": "active",
    "file": null,
    "created_at": 1492885673,
    "updated_at": 1492885673
}
```

Get User Tour List
-------------------------------
http://api.youch.me/tour/user/<username>  
Method: GET  
Answer without errors:  
```
[
    {
        "id": 12,
        "title": "New Content",
        "description": "New Desc",
        "user": {
            "id": 2,
            "username": "admin",
            "email": "admin@youch.me",
            "first_name": "Roman",
            "last_name": "Lukoyanov",
            "state": "active",
            "site": "http://youch.me/",
            "avatar": null,
            "get_messages": 1,
            "hide_events": 0,
            "birthday": "1990-10-28",
            "about": "Romashka!!!",
            "city": {
                "name": "Нижний Новгород, Россия",
                "city": "Нижний Новгород",
                "google_id": "asdashfakjslhfakjslhf",
                "lat": 52.3,
                "lng": 26.5
            }
        },
        "category": {
            "id": 1,
            "name_ru": "Туризм",
            "name_en": "Tourism",
            "created_at": 1492885673,
            "updated_at": 1492885673
        },
        "days": {
            "mon": {
                "from": "09:00",
                "to": "21:00"
            },
            "tue": {
                "from": "09:00",
                "to": "21:00"
            }
        },
        "price": 200.02,
        "is_free": true / false,
        "is_tour": true / false,
        "period": 6,
        "dates": [
            {
                "from": "2017-05-29T00:00:00+03:00",
                "to": "2017-06-04T00:00:00+03:00"
            },
            {
                "from": "2017-06-10T00:00:00+03:00",
                "to": "2017-06-16T00:00:00+03:00"
            },
            {
                "from": "2017-07-20T00:00:00+03:00",
                "to": "2017-07-26T00:00:00+03:00"
            }
        ],
        "site": "http://yandex.ru/",
        "phone": "89047946559",
        "city": {
            "name": "Брест, Беларусь",
            "city": "Брест",
            "google_id": null,
            "lat": 52,
            "lng": 23
        },
        "state": "active",
        "file": null,
        "created_at": 1492885673,
        "updated_at": 1492885673
    }
]
```

Create Tour
-------------------------------
http://api.youch.me/tour/save  
Method: POST  
Params:  
```
{
    "title": "Pass2",
    "description": "ALALA!2",
    "price": 10.05,
    "is_free": true / false,
    "dates":["2017-05-29", "2017-06-10", "2017-07-20"],
    "period": 6,
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "city": {
        "city": "Брест",
        "name": "Брест, Беларусь",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Content Object  

Update Tour
-------------------------------
http://api.youch.me/tour/save  
Method: POST  
Params:  
```
{
    "id": 14,
    "title": "Pass2",
    "description": "ALALA!2",
    "price": 10.05,
    "is_free": true / false,
    "dates":["2017-05-29", "2017-06-10", "2017-07-20"],
    "period": 6,
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "city": {
        "city": "Брест",
        "name": "Брест, Беларусь",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "category_ids": [2],
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Tour Object  

Set Image
-------------------------------
http://api.youch.me/tour/image?id=<tour_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Tour Object  

Delete Image
-------------------------------
http://api.youch.me/tour/delete-image?id=<tour_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Tour Object  

Get Comments
-------------------------------
http://api.youch.me/content/get-comments?id=<tour_id>&page=1&perpage=10  
Method: GET
  
id is required  
page is not required (default 1)  
perpage is not required (default 10)  
  
Params:  
```
{

}
```  
Answer without errors: Tour comment list

Add Comment
-------------------------------
http://api.youch.me/tour/add-comment  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "comment": "ALALALALA!"
}
```  
Answer without errors: Tour comment list    

Add Mark
-------------------------------
http://api.youch.me/tour/add-mark  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "rating": 3
}
```  
Answer without errors: Tour Object  


Black List  
==============================
Add to blocked
------------------------------
http://api.youch.me/subscription/block  
Method: POST  
Params:  
```
{
    "user_id": 6
}
```  
Answer without errors: your blocked list  

Remove from blocked
------------------------------
http://api.youch.me/subscription/remove-block  
Method: POST  
Params:  
```
{
    "user_id": 6
}
```  
Answer without errors: your blocked list  

Followers
==============================
Add to following
-------------------------------
http://api.youch.me/subscription/follow   
Method: POST  
Params:  
```
{
    "user_id": 6
}
```  
Answer without errors: your following list  

Remove from following
-------------------------------
http://api.youch.me/subscription/remove-follow  
Method: POST  
Params:  
```
{
    "user_id": 6
}
```  
Answer without errors: your following list  

Events  
===============================
Get event List  
-------------------------------
http://api.youch.me/event/?category_id=1&page=1&perpage=10  
Method: GET  

category_id is not required  
page is not required (default 1)  
perpage is not required (default 10)  

Answer without errors:  
```
{
    "total": 15,
    "models": [...Event Object List...]
}
```  

Get Event
-------------------------------
http://api.youch.me/event/<event_id>
Method: GET  
Answer without errors: Event Object  

Get User Event List
-------------------------------
http://api.youch.me/event/user/<username>/?page=1&perpage=10  
Method: GET  

page is not required (default 1)  
perpage is not required (default 10)  

Answer without errors:  
```  
{
    "total": 15,
    "models": [...Event Object List...]
}
```  

Get My Event List
-------------------------------
http://api.youch.me/user/my-events/?page=1&perpage=10  
Method: GET  

page is not required (default 1)  
perpage is not required (default 10)  

Answer without errors:  
```  
{
    "total": 15,
    "models": [...Event Object List...]
}
```  

Create Event
-------------------------------
http://api.youch.me/event/save  
Method: POST  
Params: Content Form or Tour Form (check by user role)  
```
{
    "title": "Pass2",
    "description": "ALALA!2",
    "price": 10.05,
    "is_free": true / false,
    "dates":["2017-05-29", "2017-06-10", "2017-07-20"],
    "period": 6,
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "address": {
        "city": "Брест",
        "name": "Брест, Беларусь, ул. Ленина, д.10",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Content or Tour object  

Update Event
-------------------------------
http://api.youch.me/event/save  
Method: POST  
Params: Content Form or Tour Form (check by user role)  
```
{
    "id": 14,
    "title": "Pass2",
    "description": "ALALA!2",
    "price": 10.05,
    "is_free": true / false,
    "dates":["2017-05-29", "2017-06-10", "2017-07-20"],
    "period": 6,
    "site": "http://site.com/",
    "phone": "9047946559",
    "category": {... Category Object ...},
    "address": {
        "city": "Брест",
        "name": "Брест, Беларусь",
        "lat": 52,
        "long": 23,
        "id": "dasndashdkjashd"
    },
    "category_ids": [2],
    "hours": {
        "mon": {
            "from": "09:00",
            "to": "21:00"
        },
        "tue": {
            "from": "09:30",
            "to": "21:30"
        },
        "wed": {
            "from": "10:00",
            "to": "22:00"
        }
    }
}
```  
Answer without errors: Content or Tour object  

Set Image
-------------------------------
http://api.youch.me/event/image?id=<event_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Tour Object  

Delete Image
-------------------------------
http://api.youch.me/event/delete-image?id=<event_id>  
Method: POST  
Params: Autorization header  
Image must be set by form data with name=file (extensions gif, jpg, png, jpeg)  
Answer without errors: Tour Object  

Get Comments
-------------------------------
http://api.youch.me/event/get-comments?id=<event_id>&page=1&perpage=10  
Method: GET
  
id is required  
page is not required (default 1)  
perpage is not required (default 10)    
Answer without errors:  
```
{
    "total": 15,
    "models": [...Comment Object List...]
}
```

Add Comment
-------------------------------
http://api.youch.me/event/add-comment  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "comment": "ALALALALA!"
}
```  
Answer without errors: Comment Object List    

Add Mark
-------------------------------
http://api.youch.me/event/add-mark  
Method: POST  
Params:  
```
{
    "content_id": 14,
    "rating": 3
}
```  
Answer without errors: Event Object  

Search
====================================
By city
-------------------------------
http://api.youch.me/search/by-city/?id=<google_id>&page=1&perpage=10  
Method: GET  

id is required  
page is not required (default 1)  
perpage is not required (default 10) 

Answer without errors:   
```
{
    "total": 15,
    "models": [...Tour Object List...]
}
```  

dns1.yandex.net.
dns2.yandex.net.

