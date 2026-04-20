# TMS APP - Transport Management System

* **Status:** MVP / Prototyp pod projekt inżynierski
* **Stack:** PHP 8.2+ | Laravel 12+ | Filament PHP v5 | MySQL 8.4

## O projekcie
Projekt **TMS_APP** to system do kompleksowego zarządzania logistyką i flotą. Tworzę go z myślą o wykorzystania go jako fundament pracy inżynierskiej na **Politechnice Gdańskiej (Wydział ETI)**.

## Architektura i baza danych
Baza i architektura są już w większości zaprojektowane i wdrożone:

* **Skala:** Aktualnie system składa się ze **121 znormalizowanych tabel (3NF+)**.
* **Zaawansowane modele:** Zastosowane dziedziczenie dla różnych typów pojazdów (wywrotki, ciągniki, firanki itp.).
* **System Ról:** Pełna struktura uprawnień (Admin, Technik, Kierowca, Dyspozytor, Magazynier, Księgowa).

## Uwagi dot. projektu
* **Cel:** Obecna wersja służy weryfikacji poprawności złożonych relacji bazodanowych, dlatego dane wprowadza się ręcznie.
* **Prywatność:** Ze względu na charakter projektu (praca inżynierska), główne repozytorium z kodem źródłowym pozostaje prywatne.
* **Inne:** Warstwa techniczna i kod są w języku angielskim, natomiast interfejs użytkownika (UI) posiada polskie tłumaczenia (Pol-English). Jest to stan tymczasowy na potrzeby prototypu.

## Diagram

Diagram prezentujący część systemu.

**[database_schema.pdf](./database_schema.pdf)**

## Przykładowa wizualizacja

Przykład działających paneli systemu znajduje się w załączonym pliku. Stan na dzień **03.04.2026**:

**[TMS_APP_Prezentacja.pdf](./TMS_APP_Prezentacja.pdf)**

## Przykładowe fragmenty kodu
Poniższe fragmenty to jedynie wycinek logiki systemu, mający na celu zaprezentowanie aktualnej wersji systemu.  Stan na dzień 03.04.2026:
Folder **`code_preview/`** zawiera wybrane pliki z aplikacji.
* **code_preview/app_resource/** Fragmenty konfiguracaji Filament (resource, tabela, formularz)
* **code_preview/migrations/** Wybrane migracje
* **code_preview/models/** Wybrane modele

### Przykład 1: Pracownicy i Dokumenty
Ta część projektu odpowiada za zarządzanie danymi pracowników oraz ich dokumentami.
#### Wybrane pliki 
* **Pracownik** <br>
**Migracja: [2026_02_26_144614_create_employees_table.php](./code_preview/migrations/2026_02_26_144614_create_employees_table.php)**<br>
**Model: [Employee.php](./code_preview/models/Employee.php)**<br>
* **Dokumenty Pracownika**<br>
**Migracja: [2026_02_26_193811_create_employee_documents_table.php](./code_preview/migrations/2026_02_26_193811_create_employee_documents_table.php)**<br>
**Model: [EmployeeDocument.php](./code_preview/models/EmployeeDocument.php)**<br>
**Tabela (Filament): [EmployeeDocumentsTable.php](./code_preview/app_resources/EmployeeDocuments/Tables/EmployeeDocumentsTable.php)**<br>
**Formularz (Filament): [EmployeeDocumentsForm.php](./code_preview/app_resources/EmployeeDocuments/Schemas/EmployeeDocumentForm.php)**<br>
#### Opis techniczny
* **Model Relacyjny (3NF):** Pracownik *(Employee)* jest powiązany z kontami użytkowników oraz wieloma tabelami słownikowymi (narodowości, adresy, telefony). Pozwala to na uniknięcie powtarzania danych i zachowanie czystości bazy.
* **Bezpieczeństwo danych:** Model *EmployeeDocument* posiada walidację logiczną – system uniemożliwi zapisanie dokumentu, jeśli data ważności jest wcześniejsza niż data wydania.
* **Obsługa błędów i UI:** System operuje na domyślnych komunikatach walidacji. W obecnej fazie prototypu interfejs nie posiada dedykowanych powiadomień dla każdego zdarzenia, skupiając się na logice backendowej.
* **Interfejs Filament:** Tabela dokumentów dynamicznie koloruje rekordy (Danger/Warning), informując o terminach wygasania uprawnień.
* **Obsługa załączników (Prototyp):** Obecna wersja pozwala na szybkie powiązanie skanów dokumentów z bazą danych.

### Przykład 2: Pojazdy i szczegóły
Ten fragment projektu przedstawia podejście do zarządzania zróżnicowaną flotą transportową (np. ciągniki, naczepy, cysterny) przy użyciu mechanizmu dziedziczenia danych.
#### Wybrane pliki 
* **Pojazdy** <br>
**Migracja: [2026_03_02_170535_create_vehicles_table.php](./code_preview/migrations/2026_03_02_170535_create_vehicles_table.php)**<br>
**Model: [Vehicle.php](./code_preview/models/Vehicle.php)**<br>
* **Cysterny**<br>
**Migracja: [2026_03_02_170816_create_vehicle_cargo_tank_details_table.php](./code_preview/migrations/2026_03_02_170816_create_vehicle_cargo_tank_details_table)**<br>
**Model: [VehicleCargoTankDetail.php](./code_preview/models/VehicleCargoTankDetail.php)**<br>
#### Opis techniczny
* **Dziedziczenie tabel (CTI):** System rozdziela dane na ogólne (tabela vehicles) oraz szczegółowe (np. vehicle_cargo_tank_details). Dzięki temu parametry techniczne charakterystyczne tylko dla cystern są przechowywane w dedykowanej tabeli, co pozwala uniknąć pustych pól (NULL) i zachować czystość i estetykę w bazie.
* **Struktura słownikowa:** Kluczowe parametry, powtarzalne itp. są przechowywane w wydzielonych osobnych tabelach słownikowych. Są uzupełniane za pomocą seedera. Gwarantuje to spójność danych i ułatwia filtrowanie floty
* **Integralność danych:** Migracje wykorzystują reguły onDelete('restrict') dla słowników. Zabezpiecza to system przed przypadkowym usunięciem konfiguracji (np. modelu pojazdu), która jest już przypisana do konkretnego auta.
## Plany rozwoju systemu
### 1.Dokończenie paneli
Dokończenie dedykowanych widoków dla posczególnych ról (Admin,Technik,Księgowa,Właściciel,Kierowca)
* **Administrator (SuperUser) [90%]** Ma dostęp do absolutnie wszystkiego. Zarządza całą strukturą aplikacji, uprawnieniami i może edytować każdy rekord w bazie.
* **Technik (Admin)[70%]:** Zarządza flotą i użytkownikami na co dzień. Może dodawać nowe pojazdy, zakładać konta pracownikom i poprawiać błędy we wpisach (nadzór nad danymi).
* **Właściciel** Widok biznesowy. Ma pełny wgląd w finanse, statystyki zarobków, raporty o kierowcach oraz stanie całej floty.
* **Dyspozytor** Widok i zarządzanie zleceniami, pojazdami i przypisywaniem ich do kierowców
* **Kierowca:** Widok osobisty. Ma podgląd swoich danych, przypisanych tras, pojazdów oraz historii wykonanych zleceń.
* **Księgowa** Dostęp ograniczony do finansów. Zarządza fakturami, kosztami (paliwo, serwisy) i rozliczeniami.
* **Magazynier** Widok i zarządzanie magazynem
### 2.Uproszczenie dodawania nowych danych
Wprowadzenie uproszczonych mechanizmów dodawania, wglądu do danych.
* **Asystent dodawania:** System "prowadzi za ręke" podczas dodawania nowych rekordów. Przykładowo dodając nowego pracownika, aplikacja przeprowadza użytkownika przez kolejne etapy (dane osobowe, kontaktowe, dokumenty)
* **Filtry kaskadowe:** Przebudowa aktualnych filtrów aby były zależne od siebie
* **Dynamiczne uzupełniane brakujących danych:** jezeli podczas wypelniania formularza brakuje np. Miasta itp, system pozwala ich na natychmiastowe dodanie w wyskakującym oknie, bez przerywania obecnego formularza
* **Szablony techniczne i autouzupełnianie:** Wykorzystanie celowo zdenormalizowanych tabel z wzorcami marek i modeli. Po wybraniu konkretnego modelu (np. Scania S500), system automatycznie uzupełnia dane techniczne (moc, silnik, parametry) eliminując ręczne wpisywanie powtarzalnych informacji
### 3.Automatyczna weryfikacja i synchronizacja danych
* **Weryfikacja statusów:** Automatyczne sprawdzanie daty np. ważności i zmiana flagi *is_active* na podstawie terminów (np.Koniec ważności dokumentu, przeglądu lub umowy pracownika)
* **Czyszczenie danych:** Archiwizacja starych, nieaktualnych danych w celu zachowania przejrzystości paneli aby zawieraly akutalne informacje
### 4.Wykresy i statystyki
* **Analiza zarobków:** Widoki obliczające zarobek generowany przez konkretne pojazdy (zysk - koszt eksplotacji)
* **Wykorzystanie:** Statystyka pokazująca procentowe wykorzystanie floty (np. ile dni pojazd był w trasie a ile stał)
* **Spalanie i koszty:** Automatyczne wyliczanie średniego zużycia paliwa na podstawie wpisów tankowań i przebiegów podczas tankowania
* **Wizualizacja danych:** Wykresy do monitorowania wydatków i przychodów w okreslonym czasie (tydzień/miesiąc/kwartał)
### 5.Interaktywna mapa (Vue/React + API)
Wielofunkcyjjna mapa z filtrami:
* **Zarządzanie widocznością:** Interaktywne filtry pozwalające na pokazanie/ukrycie konkretenych warstw (np. pokaż pojazdy, ukryj naczepy)
* **Pojazdy:** Wyświetlanie pojazdów na podstawie ostatnio zapisanych współrzędnych (lokalizacji)
* **Punkty logistyczne i bazy:** Wyswietlenie lokalizacji punktu rozładunku czy załadunku oraz wyświetlenie miejsc np. Garaż czy plac
* **Historia Trasy:** Podgląd do przebytej drogi po kliknieciu na dany pojazd
* **Aktulizacja mapy:** Aktulizacja mapy po określonym czasie (np. co 15minut)
### 6.Aplikacja mobilna
Lekka aplikacja dla kierowców służąca jako źródło danych dla systemu
* **Moduł GPS:** Automatyczne zbieranie i wysyłanie kordynatów do bazy w celu śledzenia pojazdu na mapie
* **Status kierowcy:** Możliwość odkliknięcia w aplikacji akutalnego statusu (np. Pauza/W trasie)
* **Szybki podgląd:** Szybki, aktualnie przypisanych zleceń 
