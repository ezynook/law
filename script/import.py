#-----------------------------
#install libraly before using
#-----------------------------
#- pip install pandas
#- pip install sqlalchemy
#- pip install pymysql
#- pip install shutil
#-----------------------------
import os
import glob
import pandas as pd
from sqlalchemy import create_engine
import pymysql as pymysql
import shutil
from urllib.parse import quote

class ImportCSV:
    #รันทันที่หลังเรียกใช้ Class
    def __init__(self) -> None:
        self.insertToDB()
    # Function Connect Database
    def MysqlConn(self):
        try:
            con = create_engine("mysql+pymysql://root:%s@localhost:3306/db_law" % quote('root'))
            return con
        except Exception as e:
            print(e.message, e.args)
    #หลังจากมีการ Import แล้วให้ทำการ Move File ไปไว้ใน tmp
    def moveTemp(self):
        source_dir = 'c:\\csv'
        target_dir = 'c:\\tmp'
            
        file_names = os.listdir(source_dir)
            
        for file_name in file_names:
            shutil.move(os.path.join(source_dir, file_name), target_dir)
    #Import
    def insertToDB(self):
        check_details = []
        check_subject = []
        path = "c:\\csv"
        all_files = glob.glob(os.path.join(path, "*.csv"))
        df_from_each_file = (pd.read_csv(f, sep='|') for f in all_files)
        df_merged = pd.concat(df_from_each_file, ignore_index=True)
        df_merged['update_dt'] = pd.to_datetime(df_merged.update_dt)
        df_merged['update_dt'] = pd.to_datetime(df_merged['update_dt']).dt.strftime('%Y-%m-%d')
        df_merged['subject'].replace(r'\\n', ' ', regex=True, inplace=True)
        df_merged['details'].replace(r'\\n', ' ', regex=True, inplace=True)
        #หัวข้อข่าวห้ามมากกว่า 1000 ตัวอักษร ความจริงเก็บได้มากกว่าแต่ไม่เหมาะ 
        for sj in df_merged['subject']:
            sj = str(sj)
            if len(sj) > 1000:
                check_subject.append(sj[0:1000])
            else:
                check_subject.append(sj)
        #รายละเอียดข่าวห้ามมากกว่า 1000 ตัวอักษร ความจริงเก็บได้มากกว่าแต่ไม่เหมาะ 
        for dt in df_merged['details']:
            dt = str(dt)
            if len(dt) > 1000:
                check_details.append(dt[0:1000])
            else:
                check_details.append(dt)
        df_merged['details'] = check_details
        df_merged['subject'] = check_subject
        #ถ้า details ว่างให้เอา subject มาใส่แทน
        if len(df_merged['details']) == 0:
            df_merged['details'] = df_merged['subject']
            
        result = pd.DataFrame(df_merged)
        #For return data to html
        row_no = len(result)
        result.to_sql('tbl_data', self.MysqlConn(), if_exists='append', index=False)
        # self.moveTemp()
        print(f'Import CSV Successfully Total {row_no} Record')

if __name__ == "__main__":
    ImportCSV()