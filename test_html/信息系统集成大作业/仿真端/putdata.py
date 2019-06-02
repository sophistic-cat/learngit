"""
@author:wgc
@Time:2019/5/10 15:19
@Version: v1.0
"""
import threading
import urllib.request
import json
import time
from time import sleep
import random
#设备ID
deviceId = "526122254"
APIKey = '0XRSWjgAa=jGEJNgJpb2dr1PNu0='


#上传函数
def http_put_data():
    url = "http://api.heclouds.com/devices/" + deviceId + '/datapoints'
    d = time.strftime('%Y-%m-%dT%H:%M:%S')
    CO2 = random.randint(0,999)
    VOC = random.randint(0,999)
    PM25 = random.randint(0,999)
    PM10 = random.randint(0,999)
    values = {"datastreams": [ {"id": "CO2", "datapoints": [{"value": CO2}]}, {"id": "PM25", "datapoints": [{"value": PM25}]},
                               {"id": "PM10", "datapoints": [{"value": PM10}]},{"id": "VOC", "datapoints": [{"value": VOC}]} ]}

    jdata = json.dumps(values).encode("utf-8")
    request = urllib.request.Request(url, jdata)
    request.add_header('api-key', APIKey)
    request.get_method = lambda: 'POST'
    request = urllib.request.urlopen(request)
    print(values)
    timer = threading.Timer(2, http_put_data)
    timer.start()
    return request.read()


if __name__ == '__main__':
    timer = threading.Timer(3, http_put_data)
    timer.start()

