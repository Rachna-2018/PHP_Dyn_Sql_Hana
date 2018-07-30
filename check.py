import requests

url = 'http://74.201.240.43:8000/ChatBot/Sample_chatbot/hana_demo.xsjs'
headers = {'Accept': 'application/json'}
auth = ('SANYAM_K', 'Welcome@123')
response = requests.get(url, headers=headers, auth=auth)

with open('outputfile.json', 'w') as outf:
    outf.write(response.content)