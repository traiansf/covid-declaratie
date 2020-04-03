# covid-declaratie

Generare si semnare automata a declaratiei pe propria răspundere

## Functionalități

- Crearea mai multor profile, inițializate cu datele fixe:
  + Nume și Prenume 
  + Data Nașterii
  + Adresa
  + Semnătura
   * fișier PNG
   * cu background-ul eliminat
   * tăiat la dimensiunea semnăturii

- Generarea unei declarații prin completarea doar a câmpurilor variabile
  + Selectarea unui profil utilizator
  + Locul/locurile deplasării
  + Motivele deplasării
  + Data este completată automat la data de azi

## Instalare

- Server Web cu PHP și posibilitatea de a executa comenzi sistem

- [ImageMagick](https://imagemagick.org/) (`convert`) cu
   [permisiunea de scriere pentru PDF](https://stackoverflow.com/a/52863413)
  + necesar pentru transformarea semnăturii într-un PDF

- [PDFtk Server](https://www.pdflabs.com/tools/pdftk-server/) (`pdftk`)
  + Completare câmpuri
  + Ștampilare declarație cu semnătura

- User-ul web trebuie sa aiba drept de scriere in directorul `models`
  + acesta va stoca Declarațiile precompletate cu datele fixe pentru utilizatori

- trebuie creat un și director `tmp` cu drept de scriere pentru user-ul `web`
  + Director de lucru; pentru fișiere temporare
