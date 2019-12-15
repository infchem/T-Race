import sqlite3
import re

db_path = "../../Server/docker/typesetter/api/db/T-Race.sqlite"
csv_path = "./umfrage-zum-konsumverhalten-ideenexpo-2019.csv"

connection = sqlite3.connect(db_path)
cursor = connection.cursor()

print("Writing data from \"{}\" to database at \"{}\".".format(csv_path, db_path))

print("Resetting tables \"UnfrageArtikel\" and \"UmfrageLaden\".")
#We might not acually want to do this every time...
cursor.execute("UPDATE UmfrageLaden "
               "SET '5-6' = 0, "
               "'7-8' = 0, "
               "'9-10' = 0, "
               "'11' = 0, "
               "'Lehrer' = 0")

cursor.execute("UPDATE UmfrageArtikel "
               "SET '5-6' = 0, "
               "'7-8' = 0, "
               "'9-10' = 0, "
               "'11' = 0, "
               "'Lehrer' = 0")

print("Starting to write to DB.")
#Reading every line and adding the db entry accordingly
with open(csv_path, "r", encoding='utf-8') as fp:
    #skip first line
    fp.readline()
    line = fp.readline()

    while line:
        data = re.findall("\"(.*?)\"", line)

        klassenStufe = data[0]

        laeden = data[1].split(", ")
        for laden in laeden:
            query = ("UPDATE UmfrageLaden "
                     "SET '{}' = \"{}\" + 1 "
                     "WHERE LID = ("
                         "SELECT L_ID "
                         "FROM Laden "
                         "WHERE name = \"{}\");"
                     ).format(klassenStufe, klassenStufe, laden)
            cursor.execute(query)

        for i in range(2, 9):
            entryName = data[i]
            if i == 7:
                #Farbe has extra case because it is named differently in the csv file.
                entryName = "Aufkleber {}".format(data[i].lower())
            elif i == 8:
                #Extra case for "Webshop" entry
                if data[i] == "PNG (Ein Bild)":
                    entryName = "Dinobild"
                elif data[i] == "MP3 (Einen Song)":
                    entryName = "Dinosong"
                else:
                    print("No webshop article \"{}\" found. Skipping entry.".format(data[i]))
                    continue

            #FIXME: Currently our data for the sports-shop is invalid because the csv content does not match the DB.

            query = ("UPDATE UmfrageArtikel "
                     "SET \"{}\" = \"{}\" + 1 "
                     "WHERE AID = ("
                         "SELECT A_ID "
                         "FROM Artikel "
                         "WHERE Bezeichnung = \"{}\");"
                     ).format(klassenStufe, klassenStufe, entryName)
            cursor.execute(query)

        line = fp.readline()

print("Finished writing to database.")

cursor.close()
connection.commit()
connection.close()
