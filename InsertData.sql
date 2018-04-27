INSERT INTO coin (Symbol, Name, Url, Max_supply, Current_supply) VALUES
('BTC', 'Bitcoin', 'https://bitcoin.org/en/', 21000000, 16910100),
('ETH', 'Ethereum', 'https://www.ethereum.org/', NULL, 98090619),
('LTC', 'Litecoin', 'https://litecoin.com/', NULL, 55557743),
('XRB', 'Nano', 'https://raiblocks.net/', 133248289, 133248289),
('XRP', 'Ripple', 'https://ripple.com/', NULL, 39091956706);

INSERT INTO exchange (Url, Name, Location) VALUES
('https://binance.com/', 'Binance', 'USA'),
('https://bittrex.com/', 'Bittrex', 'USA'),
('https://gdax.com/', 'GDAX', 'USA');

INSERT INTO current_price (Exchange_url, Symbol, Purchase_Time, Price, Volume) VALUES
('https://binance.com/', 'BTC', '2018-03-09 20:56:11', 12934.83, 324803295),
('https://binance.com/', 'ETH', '2018-03-09 20:55:55', 983.76, 32409320),
('https://binance.com/', 'ETH', '2018-03-09 20:56:05', 1240.43, 32830404),
('https://binance.com/', 'XRP', '2018-03-09 20:55:44', 1.07, 342088503),
('https://binance.com/', 'XRP', '2018-03-09 20:55:49', 2.48, 485804308),
('https://bittrex.com/', 'BTC', '2018-03-09 20:55:31', 10238, 3208400843),
('https://bittrex.com/', 'LTC', '2018-03-09 20:42:53', 1.83, 43083248),
('https://bittrex.com/', 'LTC', '2018-03-09 20:53:26', 214.83, 43083248),
('https://bittrex.com/', 'LTC', '2018-03-09 20:55:01', 214.83, 43083248),
('https://bittrex.com/', 'LTC', '2018-03-09 20:55:19', 132.69, 43085302),
('https://bittrex.com/', 'XRB', '2018-03-09 18:28:54', 34.43, 10231204),
('https://bittrex.com/', 'XRB', '2018-03-09 20:55:37', 10.32, 320843808),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:16', 13945.32, 43095905),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:22', 16000.39, 38490540),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:28', 12495.48, 39495020),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:33', 15603.58, 32409506),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:38', 19543.3, 45003003),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:44', 14083.38, 37588200),
('https://gdax.com/', 'BTC', '2018-03-09 20:56:59', 12384.73, 38298405);

INSERT INTO isateam (Symbol, Num_members) VALUES
('BTC', 4),
('ETH', 3),
('LTC', 5),
('XRB', 3),
('XRP', 1);

INSERT INTO price (Symbol, Current_price, Market_cap, hr24_change, d7_change) VALUES
('BTC', 10850.32, 32483203124, 32.4, -12.83),
('ETH', 1084.32, 3810274748, -17.08, -3.03),
('LTC', 127.38, 843974737, -8.83, 4.1),
('XRB', 13.48, 43880409213, -23.49, -1203),
('XRB', 35, 31208438024, -10.23, 40.32),
('XRP', 1.0374, 312804753, -32.8, 1.85);

INSERT INTO team_member (Symbol, Fname, Mname, Lname, Position, Yrs_experience) VALUES
('BTC', 'Edgar', 'Juan', 'Rodrigez', 'Programmer', 8),
('BTC', 'Jay', 'EB', 'Morris', 'Programmer', 15),
('BTC', 'Kim', 'Lynn', 'Morres', 'Marketing', 2),
('BTC', 'Nick', 'Miller', 'McCarty', 'Programmer', 30),
('ETH', 'Jesse', 'David', 'Regge', 'Marketing', 5),
('ETH', 'Jewda', 'Bang', 'Juan', 'Programmer', 3),
('ETH', 'Tray', 'Lewis', 'Kyle', 'Programmer', 8),
('LTC', 'Abby', 'Gale', 'Miller', 'Marketing', 1),
('LTC', 'Alex', 'J', 'Hall', 'Programmer', 5),
('LTC', 'Christrian', 'Netty', 'Hall', 'Programmer', 3),
('LTC', 'Morgan', 'Tori', 'Grail', 'Programmer', 3),
('LTC', 'Taylor', 'Ben', 'Yatogo', 'Marketing', 7),
('XRB', 'Jillian', 'Rose', 'Krehe', 'Marketing', 1),
('XRB', 'Josh', 'Amber', 'Krehe', 'Marketing', 2),
('XRB', 'Maddie', 'Torina', 'Krehe', 'Programmer', 3),
('XRB', 'Tori', 'Elizabeth', 'Krehe', 'Programmer', 0),
('XRP', 'Nathan', 'Steven', 'Maines', 'Programmer', 8);

INSERT INTO settings (Admin_password) VALUES
('comp163');
