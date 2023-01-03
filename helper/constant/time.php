<?php

/** Numero de segundos referente a um segundo */
define('TIME_SEGUNDO', 1);

/** Numero de segundos referente a um minuto */
define('TIME_MINUTO', (TIME_SEGUNDO * 60));

/** Numero de segundos referente a uma hora */
define('TIME_HORA', (TIME_MINUTO * 60));

/** Numero de segundos referente a um dia */
define('TIME_DIA', (TIME_HORA * 24));

/** Numero de segundos referente a 1 semana */
define('TIME_SEMANA', (TIME_DIA * 7));