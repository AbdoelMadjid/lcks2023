DROP TABLE IF EXISTS ak_bidangkeahlian;
CREATE TABLE `ak_bidangkeahlian` (
  `kode_bidang` char(5) NOT NULL,
  `nama_bidang` varchar(50) NOT NULL,
  PRIMARY KEY (`kode_bidang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO ak_bidangkeahlian VALUES ("01", "Teknologi dan Rekayasa");
INSERT INTO ak_bidangkeahlian VALUES ("02", "Teknologi Informasi dan Komunikasi");
INSERT INTO ak_bidangkeahlian VALUES ("03", "Kesehatan");
INSERT INTO ak_bidangkeahlian VALUES ("04", "Agrobisnis dan Agroteknologi");
INSERT INTO ak_bidangkeahlian VALUES ("05", "Perikanan dan Kelautan");
INSERT INTO ak_bidangkeahlian VALUES ("06", "Bisnis dan Manajemen");
INSERT INTO ak_bidangkeahlian VALUES ("07", "Pariwisata");
INSERT INTO ak_bidangkeahlian VALUES ("08", "Seni Rupa dan Kriya");
INSERT INTO ak_bidangkeahlian VALUES ("09", "Seni Pertunjukan");
INSERT INTO ak_bidangkeahlian VALUES ("10", "Teknologi Informasi");
INSERT INTO ak_bidangkeahlian VALUES ("11", "Bisnis dan Manajemen");



