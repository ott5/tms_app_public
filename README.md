# TMS APP - System Zarządzania Transportem

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

## Przykładowa wizualizacja
Podgląd struktury bazy oraz przykład działających paneli systemu znajduje się w załączonym pliku. Stan na dzień **03.04.2026**:

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