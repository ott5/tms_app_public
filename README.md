# TMS APP - System Zarządzania Transportem

* **Status:** MVP / Prototyp pod projekt inżynierski
* **Stack:** PHP 8.2+ | Laravel 12+ | Filament PHP v5 | MySQL 8.4

## O projekcie
Projekt **TMS_APP** to system do kompleksowego zarządzania logistyką i flotą. Tworzę go z myślą wykorzystania jako fundament pracy inżynierskiej na **Politechnice Gdańskiej (Wydział ETI)**.

## Architektura i baza danych
Baza i architektura są już w większości zaprojektowane i wdrożone:

* **Skala:** Aktualnie system składa się ze **121 znormalizowanych tabel (3NF+)**.
* **Zaawansowane modele:** Zastosowane dziedziczenie dla różnych typów pojazdów (wywrotki, ciągniki, firanki itp.).
* **System Ról:** Pełna struktura uprawnień (Admin, Technik, Kierowca, Dyspozytor, Magazynier, Księgowa).

## Uwagi dot. projektu
* **Cel:** Obecna wersja służy weryfikacji poprawności złożonych relacji bazodanowych, dlatego dane wprowadza się ręcznie.
* **Prywatność:** Ze względu na charakter projektu (praca inżynierska), główne repozytorium z kodem źródłowym pozostaje prywatne.
* **Inne:** Warstwa techniczna i kod są w języku angielskim, natomiast interfejs użytkownika (UI) posiada polskie tłumaczenia (Pol-English). Jest to stan tymczasowy na potrzeby prototypu.

## Przykładowa wizualizacja
Podgląd struktury bazy oraz przykład działających paneli systemu znajduje się w załączonym pliku. Stan na dzień **03.04.2026**:

**[TMS_APP_Prezentacja.pdf](./TMS_APP_Prezentacja.pdf)**
