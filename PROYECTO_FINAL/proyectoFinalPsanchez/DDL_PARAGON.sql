/*
DROP TABLE CUENTA;

DROP TABLE SER_AMIGOS;

DROP TABLE GALERIA;


DROP TABLE CAPTURAS;


DROP TABLE TENER_CAPTURAS;


DROP TABLE GEMAS;

DROP TABLE CARTAS;

DROP TABLE DESBLOQUEAR;

DROP TABLE HEROES;

DROP TABLE RECOMENDAR;


DROP TABLE ASIGNAR;


DROP TABLE TENER_HEROES;


DROP TABLE HEROE_PERSONALIZADO;


DROP TABLE MAGOS;


DROP TABLE HABILIDADES_ESPECIALES;
*/


CREATE TABLE CUENTA
(
    EMAIL VARCHAR2(50) NOT NULL,
    NOMBRE VARCHAR2(50) NOT NULL,
    FECHA_CREACION DATE,
    NVL_CUENTA NUMBER(10),
    CONSTRAINT PK_CUENTA PRIMARY KEY(EMAIL),
    CONSTRAINT UK_NOMBRE UNIQUE(NOMBRE)
);

CREATE TABLE SER_AMIGOS
(
    EMAIL_CUENTA VARCHAR2(50) NOT NULL,
    EMAIL_AMIGO VARCHAR2(50) NOT NULL,
    FECHA_AMIGOS DATE,
    CONSTRAINT PK_SER_AMIGOS PRIMARY KEY(EMAIL_CUENTA, EMAIL_AMIGO),
    CONSTRAINT FK_SER_AMIGOS_CUENTA_PROPIA FOREIGN KEY(EMAIL_CUENTA) 
        REFERENCES CUENTA(EMAIL),
    CONSTRAINT FK_SER_AMIGOS_CUENTA_AMIGO FOREIGN KEY(EMAIL_CUENTA) 
        REFERENCES CUENTA(EMAIL)
);


CREATE TABLE GALERIA
(
    CODIGO_GALERIA NUMBER(10) NOT NULL,
    EMAIL_CUENTA_GALERIA VARCHAR2(50) NOT NULL,
    PUBLICA VARCHAR2(1),
    NOMBRE_GALERIA VARCHAR2(50),
    CONSTRAINT PK_GALERIA PRIMARY KEY(CODIGO_GALERIA),
    CONSTRAINT FK_EMAIL_CUENTA_GALERIA FOREIGN KEY(EMAIL_CUENTA_GALERIA)
        REFERENCES CUENTA(EMAIL)
);


CREATE TABLE CAPTURAS
(
    CODIGO_CAPTURAS NUMBER(10) NOT NULL,
    EMAIL_CUENTA_CAPTURAS VARCHAR2(50) NOT NULL,
    NOMBRE_CAPTURA VARCHAR2(100) NOT NULL,
    CONSTRAINT PK_CAPTURAS PRIMARY KEY(CODIGO_CAPTURAS),
    CONSTRAINT FK_EMAIL_CUENTA_CAPTURAS FOREIGN KEY(EMAIL_CUENTA_CAPTURAS)
        REFERENCES CUENTA(EMAIL)
);


CREATE TABLE TENER_CAPTURAS
(
    CODIGO_CAPTURAS_TENER NUMBER(10) NOT NULL,
    CODIGO_GALERIA_TENER NUMBER(10) NOT NULL,
    CONSTRAINT PK_TENER_CAPTURAS PRIMARY KEY(CODIGO_CAPTURAS_TENER,
        CODIGO_GALERIA_TENER),
    CONSTRAINT FK_CODIGO_CAPTURAS_TENER FOREIGN KEY(
        CODIGO_CAPTURAS_TENER) REFERENCES CAPTURAS(CODIGO_CAPTURAS),
    CONSTRAINT FK_CODIGO_GALERIA_TENER FOREIGN KEY(
        CODIGO_GALERIA_TENER) REFERENCES GALERIA(CODIGO_GALERIA)
);


CREATE TABLE GEMAS
(
    CODIGO_GEMAS NUMBER(10) NOT NULL,
    TIPO VARCHAR2(50),
    CONSTRAINT PK_GEMAS PRIMARY KEY(CODIGO_GEMAS)
);


CREATE TABLE CARTAS
(
    NOMBRE_CARTAS VARCHAR2(50) NOT NULL,
    DESCRIPCION_CARTAS VARCHAR2(1000),
    CONSTRAINT PK_CARTAS PRIMARY KEY(NOMBRE_CARTAS)
);


CREATE TABLE DESBLOQUEAR
(
    CODIGO_GEMAS_DESBLOQUEAR NUMBER(10) NOT NULL,
    EMAIL_DESBLOQUEAR VARCHAR2(50) NOT NULL,
    NVL_DESBLOQUEAR NUMBER(10) NOT NULL,
    NOMBRE_CARTAS_DESBLOQUEAR VARCHAR2(50) NOT NULL,
    CONSTRAINT PK_DESBLOQUEAR PRIMARY KEY(EMAIL_DESBLOQUEAR, 
        NVL_DESBLOQUEAR, NOMBRE_CARTAS_DESBLOQUEAR),
    CONSTRAINT UK_DESBLOQUEAR UNIQUE(NVL_DESBLOQUEAR, EMAIL_DESBLOQUEAR, 
        CODIGO_GEMAS_DESBLOQUEAR),
    CONSTRAINT FK_CODIGO_GEMAS_DESBLOQUEAR FOREIGN KEY(
        CODIGO_GEMAS_DESBLOQUEAR) REFERENCES GEMAS(CODIGO_GEMAS),
    CONSTRAINT FK_NOMBRE_CARTAS_DESBLOQUEAR FOREIGN KEY(
        NOMBRE_CARTAS_DESBLOQUEAR) REFERENCES CARTAS(NOMBRE_CARTAS),
    CONSTRAINT FK_EMAIL_DESBLOQUEAR FOREIGN KEY(
        EMAIL_DESBLOQUEAR) REFERENCES CUENTA(EMAIL)
);


CREATE TABLE HEROES
(
    NOMBRE_HEROE VARCHAR2(50) NOT NULL,
    NVL_HEROE NUMBER(10),
    P_DANYO_HEROE NUMBER(10),
    P_VELOCIDAD_HEROE NUMBER(10),
    CONSTRAINT PK_HEROES PRIMARY KEY(NOMBRE_HEROE)
);


CREATE TABLE RECOMENDAR
(
    NOMBRE_HEROE_RECOMENDAR VARCHAR2(50) NOT NULL,
    CODIGO_GEMAS_RECOMENDAR NUMBER(10) NOT NULL,
    NOMBRE_CARTAS_RECOMENDAR VARCHAR2(50) NOT NULL,
    CONSTRAINT PK_RECOMENDAR PRIMARY KEY(CODIGO_GEMAS_RECOMENDAR,
        NOMBRE_CARTAS_RECOMENDAR, NOMBRE_HEROE_RECOMENDAR),
    CONSTRAINT FK_CODIGO_GEMAS_RECOMENDAR FOREIGN KEY(
        CODIGO_GEMAS_RECOMENDAR) REFERENCES GEMAS(CODIGO_GEMAS),
    CONSTRAINT FK_CODIGO_CARTAS_RECOMENDAR FOREIGN KEY(
        NOMBRE_CARTAS_RECOMENDAR) REFERENCES CARTAS(NOMBRE_CARTAS),
    CONSTRAINT FK_NOMBRE_HEROE_RECOMENDAR FOREIGN KEY(
        NOMBRE_HEROE_RECOMENDAR) REFERENCES HEROES(NOMBRE_HEROE)
);


CREATE TABLE ASIGNAR
(
    NOMBRE_HEROE_ASIGNAR VARCHAR2(50) NOT NULL,
    NOMBRE_CARTAS_DESBLOQUEAR_ASIG VARCHAR2(50) NOT NULL,
    CODIGO_GEMAS_DESBLOQUEAR_ASIG NUMBER(10) NOT NULL,
    NVL_DESBLOQUEAR_ASIGNAR NUMBER(10) NOT NULL,
    EMAIL_DESBLOQUEAR_ASIGNAR VARCHAR2(50) NOT NULL,
    CONSTRAINT PK_ASIGNAR PRIMARY KEY(NVL_DESBLOQUEAR_ASIGNAR, 
        EMAIL_DESBLOQUEAR_ASIGNAR, NOMBRE_CARTAS_DESBLOQUEAR_ASIG,
        NOMBRE_HEROE_ASIGNAR, CODIGO_GEMAS_DESBLOQUEAR_ASIG),
    CONSTRAINT FK_DESBLOQUEAR FOREIGN KEY(NVL_DESBLOQUEAR_ASIGNAR,
        EMAIL_DESBLOQUEAR_ASIGNAR, NOMBRE_CARTAS_DESBLOQUEAR_ASIG)
        REFERENCES DESBLOQUEAR(NVL_DESBLOQUEAR, EMAIL_DESBLOQUEAR,
        NOMBRE_CARTAS_DESBLOQUEAR),
    CONSTRAINT FK_DESBLOQUEAR_UK FOREIGN KEY(NVL_DESBLOQUEAR_ASIGNAR,
        EMAIL_DESBLOQUEAR_ASIGNAR, CODIGO_GEMAS_DESBLOQUEAR_ASIG)
        REFERENCES DESBLOQUEAR(NVL_DESBLOQUEAR, EMAIL_DESBLOQUEAR,
        CODIGO_GEMAS_DESBLOQUEAR)
);


CREATE TABLE TENER_HEROES
(
    EMAIL_CUENTA_TENER VARCHAR2(50) NOT NULL,
    NOMBRE_HEROE_TENER VARCHAR2(50) NOT NULL,
    CONSTRAINT PK_TENER_HEROES PRIMARY KEY(EMAIL_CUENTA_TENER,
        NOMBRE_HEROE_TENER),
    CONSTRAINT FK_EMAIL_CUENTA_TENER FOREIGN KEY(EMAIL_CUENTA_TENER)
        REFERENCES CUENTA(EMAIL),
    CONSTRAINT FK_NOMBRE_HEROE_TENER FOREIGN KEY(NOMBRE_HEROE_TENER)
        REFERENCES HEROES(NOMBRE_HEROE)
);


CREATE TABLE HEROE_PERSONALIZADO
(
    NOMBRE_HEROE_PERSON VARCHAR2(50) NOT NULL,
    ELEMENTO VARCHAR2(50),
    EMAIL_CUENTA_HEROE_PERSON VARCHAR2(50) NOT NULL,
    CONSTRAINT PK_HEROE_PERSONALIZADO PRIMARY KEY(NOMBRE_HEROE_PERSON),
    CONSTRAINT UK_HEROE_PERSONALIZADO UNIQUE(EMAIL_CUENTA_HEROE_PERSON),
    CONSTRAINT FK_NOMBRE_HEROE_PERSON FOREIGN KEY(NOMBRE_HEROE_PERSON)
        REFERENCES HEROES(NOMBRE_HEROE),
    CONSTRAINT FK_EMAIL_CUENTA_HEROE_PERSON FOREIGN KEY(
        EMAIL_CUENTA_HEROE_PERSON) REFERENCES CUENTA(EMAIL)
);


CREATE TABLE MAGOS
(
    NOMBRE_HEROE_MAGO VARCHAR2(50) NOT NULL,
    P_DANYO_MAGICO NUMBER(10),
    CONSTRAINT PK_MAGOS PRIMARY KEY(NOMBRE_HEROE_MAGO),
    CONSTRAINT FK_NOMBRE_HEROE_MAGO FOREIGN KEY(
        NOMBRE_HEROE_MAGO) REFERENCES HEROES(NOMBRE_HEROE)
);


CREATE TABLE HABILIDADES_ESPECIALES
(
    ID_HABILIDAD_ESPECIAL NUMBER(10) NOT NULL,
    P_VELOCIDAD_HABILIDAD NUMBER(10),
    P_CURA_HABILIDAD NUMBER(10),
    P_DANYO_HABILIDAD NUMBER(10),
    NOMBRE_HEROE_HABILIDAD VARCHAR2(50),
    CONSTRAINT PK_HABILIDADES_ESPECIALES PRIMARY KEY(
        ID_HABILIDAD_ESPECIAL),
    CONSTRAINT FK_NOMBRE_HEROE_HABILIDAD FOREIGN KEY(
        NOMBRE_HEROE_HABILIDAD) REFERENCES HEROES(NOMBRE_HEROE)
);

ALTER TABLE GEMAS ADD DESCRIPCION_GEMAS VARCHAR2(50);
