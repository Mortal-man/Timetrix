::[Bat To Exe Converter]
::
::fBE1pAF6MU+EWHreyHcjLQlHcC+nEkqSOpEZ++Pv4Pq7lkQQUfYtcZfn7r2DJfQB413YZYMv2nNZpM0NGhJbcRyXaA4ioG1NuFvQZpWE5l6zB1qM60QmHmdzynPCiT0yZcQmis0Esw==
::YAwzoRdxOk+EWAjk
::fBw5plQjdCyDJGyX8VAjFDBxYiWqAE+1EbsQ5+n//NaBo1sUV+0xR9qKiKzbcbJe+EDpeoAo1H0XiNkJGhJdaVyibQBU
::YAwzuBVtJxjWCl3EqQJgSA==
::ZR4luwNxJguZRRnk
::Yhs/ulQjdFy5
::cxAkpRVqdFKZSjk=
::cBs/ulQjdFy5
::ZR41oxFsdFKZSTk=
::eBoioBt6dFKZSDk=
::cRo6pxp7LAbNWATEpCI=
::egkzugNsPRvcWATEpCI=
::dAsiuh18IRvcCxnZtBNQ
::cRYluBh/LU+EWAjk
::YxY4rhs+aU+JeA==
::cxY6rQJ7JhzQF1fEqQJQ
::ZQ05rAF9IBncCkqN+0xwdVs0
::ZQ05rAF9IAHYFVzEqQJQ
::eg0/rx1wNQPfEVWB+kM9LVsJDGQ=
::fBEirQZwNQPfEVWB+kM9LVsJDGQ=
::cRolqwZ3JBvQF1fEqQJQ
::dhA7uBVwLU+EWDk=
::YQ03rBFzNR3SWATElA==
::dhAmsQZ3MwfNWATElA==
::ZQ0/vhVqMQ3MEVWAtB9wSA==
::Zg8zqx1/OA3MEVWAtB9wSA==
::dhA7pRFwIByZRRnk
::Zh4grVQjdCyDJGyX8VAjFDBxYiWqAE+/Fb4I5/jH2+OKp1kPXfp/WZ/LlLGWJYA=
::YB416Ek+ZG8=
::
::
::978f952a14a936cc963da21a135fa983
@echo off
cd C:\Users\KENAH\Desktop\Timetrix\Timetrix
start "" /MIN cmd /c "php artisan serve"
timeout /t 5 >nul
start http://127.0.0.1:8000
exit