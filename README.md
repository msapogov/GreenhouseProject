# Контроллер теплицы на Arduino Mega
<p>

В папке SOFT - текущая версия конфигуратора, коннектится к Меге по COM-порту.
<br/>В папке Mega - прошивка для Меги.
<br/>
# Скриншоты конфигуратора
<img src="screen1.png" hspace='10'/>
<img src="screen2.png" hspace='10'/>
<img src="screen3.png" hspace='10'/>
<img src="screen4.png" hspace='10'/>
<img src="screen5.png" hspace='10'/>
<p>
# Как использовать
<p>
<b>Установить библиотеку OneWire (в папке Libraries архива) в среду Arduino IDE!</b>
<p>
<b>Все настройки прошивки перед компиляцией - в файле Globals.h!</b>
<p>
Распаковать архив в папку на диске, установить библиотеку <b>OneWire</b>. Затем открыть в Arduino IDE файл <b>Main.ino</b>, настроить директивы условной компиляции (файл <b>Globals.h</b>), скомпилировать его и закачать в Мегу. Подсоединить зелёный светодиод к пину 6, красный - к пину 7, ещё один - к пину 8. При необходимости - подсоединить модули часов реального времени, GSM и другие. Открыть конфигуратор и подключиться к COM-порту, на котором висит Мега. При старте зелёный светодиод поморгает несколько раз и загорится. При переводе режима работы с автоматического на ручной - начинает моргать красный светодиод. Принципиальная схема подключения всего железного добра указана ниже:<br/>
<img src="plan.png"/>

<h2>Модуль часов реального времени DS3231</h2>

В текущей версии используется модуль часов реального времени на микросхеме DS3231 (пин 20 - SDA, пин 21 - SCL). Если вам не нужно использование этого модуля - закомментируйте USE_DS3231_REALTIME_CLOCK в файле Globals.h.

<h2>GSM-модуль Neoway M590</h2>

В текущей версии используется GSM-модуль на базе чипа NEOWAY M590. Если вы не хотите использовать управление по SMS - закомментируйте USE_SMS_MODULE в файле Globals.h. 
Если у вас возникли проблемы с работой SMS-модуля - можно включить отладочный режим (<b>не работает совместно с конфигуратором!</b>), раскомментировав NEOWAY_DEBUG_MODE в файле Globals.h. <b>Внимание!</b> Для контроля доступности GSM-модуля используется его выход VCCIO (ножка номер 6 по даташиту). Если у вас эта ножка не выведена на плате - надо подпаяться к чипу. Как подключать (смотри принципиальную схему выше): от ноги VCCIO чипа NEOWAY M590 идёт контакт на пин 2 Меги, этот пин подтянут к земле резистором номиналом 100К.
<p>
Список команд для управления по SMS - смотрите в конфигураторе. Если вы посылаете команду на открытие или закрытие окон - контроллер автоматически переходит в ручной режим работы!

<h2>Модуль управления поливом</h2>

<b>ВНИМАНИЕ!</b> Реле, используемые в текущей версии прошивки, включаются по низкому уровню. Если у вас наоборот - смотрите настройки WATER_RELAY_ON и WATER_RELAY_OFF в файле Globals. h.
<p>
Для индикации ручного режима управления поливом на пин 8 выведен светодиод (см. схему), который будет мигать при переключении в ручной режим работы. Для управления каналами реле задействованы пины 22, 23, 24, с которых идёт управление тремя каналами реле. Можно рулить каким угодно количеством реле, вплоть до 8. Для изменения кол-ва реле в файле Globals.h установите WATER_RELAYS_COUNT в нужное число - от 1 до 8. Пины прописываются в WATER_RELAYS_PINS, каждый пин указывается через запятую, их общее количество должно быть равным количеству, указанному в настройке WATER_RELAYS_COUNT!
<p>
При подаче любой команды модулю управления поливом (начать/закончить полив, а также когда настройка "Автоматическое управление поливом" в положении "выключено") - контроллер переходит в ручной режим управления поливом, при этом мигает светодиод на пине 8. Номер пина для диода можно изменить с помощью настройки DIODE_WATERING_MANUAL_MODE_PIN в файле Globals.h.

<h2>Модуль освещенности BH1750</h2>

В текущей версии используется модуль освещенности на базе чипа BH1750. Если вам не нужно использование этого модуля - закомментируйте USE_LUMINOSITY_MODULE в файле Globals.h. Схема подключения модуля освещенности приведена выше.

# Конфигуратор

Конфигуратор автоматически подцепляет прошитые в контроллер модули, и показывает вкладки управления этими модулями, после соединения с контроллером. Если вы не видите вкладку управления поливом (например) - смотрите директивы условной компиляции на предмет того, выключен ли модуль из компиляции или нет. При перезагрузке контроллера он переходит в автоматический режим работы, даже если при последнем обращении к нему был выставлен ручной режим.


# Ограничения, фичи и ошибки текущей редакции

Система поддерживает сложные цепочки правил, однако в целях упрощения настройки контроллера конечным юзером эти правила спрятаны глубоко внутри. Каждое правило позволяет настроить поведение контроллера в зависимости от условий на датчиках (сейчас пока поддерживается только температура). Например, команда:

<blockquote>
CTSET=ALERT|RULE_ADD|N1|STATE|TEMP|1|<|10|4|30|N2,N4|CTSET=STATE|WINDOW|ALL|CLOSE
</blockquote>

гласит: добавить правило номер один, которое работает ночью (00:00-07:00), закрывает форточки, если температура на датчике 1 меньше 10 градусов, правило активно 30 минут, и не выполняется, если сработало любое из правил под именами N2 и N4.
<p>
В общем, из-за сильной замороченности для конечного пользователя работа с такими расширенными правилами пока спрятана. Возможно, будет сделана версия конфигуратора для "гиков", в которой будет кнопочка "а сделай мне расширенные правила", которая и будет рулить раскидистой сетью условий.
<p>
В любом случае - вникнув в синтаксис правил (см. Globals.h), ничего не мешает скормить контроллеру команду на добавление правила через монитор порта, и потом - скормить ему команду на сохранение правил. Да, неудобно, но пока то, что есть. Если будет достаточно плюсов "за" вытаскивание расширенных правил на свет божий - вытащу их в конфигуратор.

