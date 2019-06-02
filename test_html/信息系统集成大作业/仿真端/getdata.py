"""
@author:wgc
@Time:2019/5/9 13:55
@Version: v1.0
"""

import requests
import json

#设备ID
deviceId = "526122254"
APIKey = '0XRSWjgAa=jGEJNgJpb2dr1PNu0='

# 基本设置
url = "http://api.heclouds.com/devices/"+deviceId+"/datastreams"
headers = {'api-key': APIKey}

# 获得结果并打印
r = requests.get(url, headers=headers)
t: str = r.text


#print(t)
params = json.loads(t)
#上面这个语句是将我们获得的内容转成数据字典，这样转是因为我们接收到的内容具有数据字典的形式
#转换成数据字典利于我们后面的操作
#print params['error'][]


#print(type(params))
#如果执行上面这条语句我们可以看到返回的结果是dict,也就是我们已经成功转换


x = params['data']
#这个语句是从数据转换后的数据字典中获取我们需要的数据,从结果上看params是一个list
#在data前面的都只是一些描述内容，参考教程：https://blog.csdn.net/zhiaicq_r/article/details/79278530


print('环境参数'+'\t\t\t\t'+'更新时间'+'\t\t\t\t\t'+'数值')
#接下来是获取不同的数据流
for index,values in enumerate(x):
    #只需要更新时间，id和值，所以这里对获得的数据字典做一下更改
    #print(values)
    #这里得到的values也是一个数据字典

    #因为在onenet那边对这些数据没有给出来，而且也没有意义，所以我们就不在这里显示，因此现将其删除
    del values['unit']
    del values['unit_symbol']
    del values['create_time']

    #print(values.items())


    #print(values['update_at'])
    #这里不知道为什么直接使用values.get('update_at','')和values.get('current_value','')
    #或者用values['update_at']和values['current_value']报：KeyError错误，而且if里面的那条语句会执行
    #所以我们通过get方法解决，其中要注意的是，如果没有给定第二个参数，那么默认输出NONE
    a= str(values.get('update_at',''))
    b= str(values.get('current_value',''))

    #因为如果有更新时间就会有相应最新的值，所以这里只用其中一个作为判断条件
    if (a != ""):
        if (values['id'] == 'PM25' or values['id'] == 'PM10' ):
            print(str(values['id']) + '\t\t\t' + a + '\t\t\t' + b)
        else:
            print(str(values['id']) + '\t\t\t\t' + a + '\t\t\t'+ b)
    else:
        if(values['id'] == 'VOC' or values['id'] == 'VOC'):

           print(values['id']+ '\t\t\t' +'目前还没有收到任何数据')
        else:
           print(values['id'] + '\t\t' + '目前还没有收到任何数据')









