# 响应

错误响应与正确响应返回结构一致

example:

```
    {
      code:    200
      message: success
      data:    []
    }
    
    {
      code:    400
      message: 请求参数错误
      data:    null
     }
    
```

Controller 返回错误与正确响应

错误：直接抛出异常

正确: 直接return 

