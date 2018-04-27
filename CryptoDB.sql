CREATE TABLE coin (
  Symbol varchar(5) NOT NULL,
  Name varchar(20) NOT NULL,
  Url varchar(80) DEFAULT NULL,
  Max_supply bigint DEFAULT NULL,
  Current_supply bigint DEFAULT NULL
);

CREATE TABLE current_price (
  Exchange_url varchar(80) NOT NULL,
  Symbol varchar(5) NOT NULL,
  Purchase_Time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Price float NOT NULL,
  Volume bigint DEFAULT NULL
);

CREATE TABLE exchange (
  Url varchar(80) NOT NULL,
  Name text NOT NULL,
  Location text
);

CREATE TABLE isateam (
  Symbol varchar(5) NOT NULL,
  Num_members int NOT NULL
);

CREATE TABLE price (
  Symbol varchar(5) NOT NULL,
  Current_price float NOT NULL,
  Market_cap bigint NOT NULL,
  hr24_change float DEFAULT NULL,
  d7_change float DEFAULT NULL
);

CREATE TABLE team_member (
  Symbol varchar(5) NOT NULL,
  Fname varchar(20) NOT NULL,
  Mname varchar(20) NOT NULL,
  Lname varchar(20) NOT NULL,
  Position text,
  Yrs_experience int DEFAULT NULL
);

CREATE TABLE settings (
  Admin_password varchar(20) NOT NULL
);

ALTER TABLE coin
  ADD PRIMARY KEY (Symbol);

ALTER TABLE current_price
  ADD PRIMARY KEY (Exchange_url,Symbol,Purchase_Time);

ALTER TABLE exchange
  ADD PRIMARY KEY (Url);

ALTER TABLE isateam
  ADD PRIMARY KEY (Symbol);

ALTER TABLE price
  ADD PRIMARY KEY (Symbol,Current_price,Market_cap);

ALTER TABLE team_member
  ADD PRIMARY KEY (Symbol,Fname,Mname,Lname);

ALTER TABLE settings
  ADD PRIMARY KEY (Admin_password);

ALTER TABLE current_price
  ADD CONSTRAINT current_price_ibfk_1 FOREIGN KEY (Symbol) REFERENCES coin (Symbol),
  ADD CONSTRAINT current_price_ibfk_2 FOREIGN KEY (Exchange_url) REFERENCES exchange (Url);

ALTER TABLE isateam
  ADD CONSTRAINT isateam_ibfk_1 FOREIGN KEY (Symbol) REFERENCES coin (Symbol);

ALTER TABLE price
  ADD CONSTRAINT price_ibfk_1 FOREIGN KEY (Symbol) REFERENCES coin (Symbol);

ALTER TABLE team_member
  ADD CONSTRAINT team_member_ibfk_1 FOREIGN KEY (Symbol) REFERENCES coin (Symbol);
