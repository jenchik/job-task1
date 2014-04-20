CREATE TABLE IF NOT EXISTS `department` (
  `id` serial,
  `name` varchar(250) NOT NULL DEFAULT '',
  CONSTRAINT pk_department PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Otdel1'),
(2, 'Otdel2'),
(3, 'Otdel3');

CREATE TABLE IF NOT EXISTS `vacancy` (
  `id` serial,
  `id_department` bigint,
  CONSTRAINT pk_vacancy PRIMARY KEY (id),
  CONSTRAINT fk_vacancy_department FOREIGN KEY (id_department)
      REFERENCES department (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  KEY `id_department` (`id_department`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `vacancy` (`id`, `id_department`) VALUES
(1, 1),
(2, 2),
(3, 1);

CREATE TABLE IF NOT EXISTS `vacancy_trans` (
  `id` serial,
  `id_vacancy` bigint,
  `lang` varchar(8) NOT NULL DEFAULT 'en_US',
  `name` varchar(250) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  CONSTRAINT pk_vacancy_trans PRIMARY KEY (id),
  CONSTRAINT fk_trans_vacancy FOREIGN KEY (id_vacancy)
      REFERENCES vacancy (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  UNIQUE KEY `lang` (`id_vacancy`,`lang`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `vacancy_trans` (`id_vacancy`, `lang`, `name`, `desc`) VALUES
(1, 'ru_RU', 'Вакансия1', 'Описание для вакансии1'),
(2, 'ru_RU', 'Вакансия2', 'Пример для вакансии2'),
(3, 'ru_RU', 'Вакансия3', 'Пример для вакансии3'),
(1, 'en_US', 'Vacancy1', 'descr1'),
(2, 'en_US', 'Vacancy2', 'descr2'),
(3, 'en_US', 'Vacancy3', 'descr3');

