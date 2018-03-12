create database faq;
use faq;

create table Utenti(IDUtenteDom int auto_increment primary key,
					prof boolean,
					Nome varchar(40),
					Cognome varchar(40),
					Username varchar(40) unique,
					Password varchar(80),
					Classe varchar(10));


create table Domande(IDDomanda int auto_increment primary key,
                     IDUtenteDom int,
                     IP text,
                     OS text,
                     Domanda text,
                     Testo text,
                     DataDom date,
                     OraDom time,
					 foreign key (IDUtenteDom) references Utenti(IDUtenteDom) on update cascade on delete cascade);
                     
create table Risposte(IDRisposta int auto_increment primary key,
                      IDUtenteRisp int,
                      IP text,
                      OS text,
                      Testo text,
                      DataRisp date,
                      OraRisp time,
                      VotiRisp int,
                      IDDomanda int,
					  foreign key (IDUtenteRisp) references Utenti(IDUtenteDom) on update cascade on delete cascade,
                      foreign key (IDDomanda) references Domande(IDDomanda) on update cascade on delete cascade);
                      
create table Votazioni(IDVotazione int auto_increment primary key,
                       IDUtenteVotazione int,
                       N_stelle int,
                       IDRisposta int,
					   foreign key (IDUtenteVotazione) references Utenti(IDUtenteDom) on update cascade on delete cascade,
                       foreign key (IDRisposta) references Risposte(IDRisposta) on update cascade on delete cascade);
                 
insert into Utenti values (null,true,"Francesco","Verdi","fraverdi","$2y$10$z0ggmKdVylJAun/8zwp6rOZt0SN/1pyVDlJfSbI7iXx2dx4R4v0Ku",null); /* username: fraverdi - password: profverdi2015 */
insert into Utenti values (null,true,"Mario","Rossi","marrossi","$2y$10$0ZgMuLGnJanGvN7PPUF4GOX/NDRSHguya5gDcnnKLMXgikmJvs812",null);	  /* username: marrossi - password: profrossi2015 */