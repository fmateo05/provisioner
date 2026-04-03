--
-- PostgreSQL database dump
--

\restrict tbVWK1WpKUFDG4ZN0ylpqAuyciVRfuwWiVt825fcPnFR0dsERHWVFydOo0B8Lyk

-- Dumped from database version 13.23 (Debian 13.23-0+deb11u1)
-- Dumped by pg_dump version 13.23 (Debian 13.23-0+deb11u1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: brands; Type: TABLE; Schema: public; Owner: provisioner
--

CREATE TABLE public.brands (
    id integer NOT NULL,
    brand character varying(50),
    family character varying(50),
    model character varying(50)
);


ALTER TABLE public.brands OWNER TO provisioner;

--
-- Name: models; Type: TABLE; Schema: public; Owner: provisioner
--

CREATE TABLE public.models (
    brand character varying(50),
    family character varying(35),
    model character varying(50),
    id integer NOT NULL
);


ALTER TABLE public.models OWNER TO provisioner;

--
-- Name: models_id_seq; Type: SEQUENCE; Schema: public; Owner: provisioner
--

ALTER TABLE public.models ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.models_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: provisioner_id_seq; Type: SEQUENCE; Schema: public; Owner: provisioner
--

ALTER TABLE public.brands ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.provisioner_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: provisioner
--

INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (1, 'aastra', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (2, 'acrobits', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (3, 'algo', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (4, 'atcom', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (5, 'avaya', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (6, 'cisco', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (7, 'digium', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (8, 'escene', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (9, 'fanvil', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (10, 'flyingvoice', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (11, 'grandstream', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (12, 'groundwire', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (13, 'htek', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (14, 'linksys', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (15, 'linphone', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (16, 'mitel', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (17, 'obihai', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (18, 'panasonic', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (19, 'poly', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (20, 'polycom', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (21, 'sangoma', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (22, 'sipnetic', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (23, 'snom', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (24, 'spectralink', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (25, 'swissvoice', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (26, 'telekonnectors', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (27, 'vtech', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (28, 'yealink', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (29, 'yeastar', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (30, 'zoiper', NULL, NULL);
INSERT INTO public.brands OVERRIDING SYSTEM VALUE VALUES (61, 'portsip', NULL, NULL);


--
-- Data for Name: models; Type: TABLE DATA; Schema: public; Owner: provisioner
--

INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '4xxx', '480i', 1430);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '67xx', '673x', 1431);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '67xx', '675x', 1432);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '68xx', '686x', 1433);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '91xxx', '9112i', 1434);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '91xxx', '9133i', 1435);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('acrobits', 'default', 'default', 1436);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8103', 1437);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8180', 1438);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8196', 1439);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('atcom', 'agxxx', 'ag198', 1440);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '7940', 1446);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '7960', 1447);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '79x1', 1448);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8811', 1449);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8832', 1450);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8841', 1451);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8845', 1452);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8851', 1453);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8861', 1454);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8865', 1455);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '9861', 1456);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa112', 1457);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa122', 1458);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa191', 1459);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa192', 1460);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa301', 1461);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa303', 1462);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa501g', 1463);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa502g', 1464);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa504g', 1465);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa508g', 1466);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa509g', 1467);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa512g', 1468);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa514g', 1469);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa525g', 1470);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa525g2', 1471);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd4x', 'd40', 1472);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd5x', 'd50', 1473);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd60', 1474);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd62', 1475);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd65', 1476);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd7x', 'd70', 1477);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('escene', 'e3xx', 'e3xx', 1478);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'hx', 'h2u-v2', 1479);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'hx', 'h5', 1480);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'I', 'i30', 1481);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'vxx', 'v67', 1482);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1s', 1483);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1sg', 1484);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1sp', 1485);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x2x', 'x210', 1486);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x2x', 'x2p', 1487);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3g', 1488);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sg', 1489);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sp', 1490);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sw', 1491);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3u', 1492);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3u-pro', 1493);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4', 1494);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4g', 1495);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4sg', 1496);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4u', 1497);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x5x', 'x5s', 1498);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x5x', 'x5u', 1499);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x6x', 'x6', 1500);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x6x', 'x6u', 1501);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7', 1502);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7a', 1503);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7c', 1504);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'audiokit', 'audiokit', 1505);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'i86x', 'i86box', 1514);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'metalbox', 'imetalbox', 1515);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gswave', 'gswave', 1562);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10', 1516);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10g', 1517);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10lte', 1518);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10p', 1519);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10w', 1520);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11', 1521);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11g', 1522);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11lte', 1523);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11p', 1524);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20', 1526);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20g', 1527);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20p', 1528);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20w', 1529);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21', 1530);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21p', 1531);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21w', 1532);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p22g', 1533);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p22p', 1534);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p23g', 1535);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33', 1538);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33g', 1539);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33p', 1540);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p510', 1541);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p53', 1542);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p54', 1543);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p55', 1544);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p57', 1545);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p58', 1546);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp715', 1547);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp715.sm', 1548);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp750', 1549);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gac', 'gac2500', 1550);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gds', 'gds3705', 1551);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gds', 'gds3710', 1552);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ghp', 'ghp6xx', 1553);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2612', 1554);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2612w', 1555);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2613', 1556);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2614', 1557);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2615', 1558);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2616', 1559);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp261x', 1560);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp26xx', 1561);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp110x', 1563);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp116x', 1564);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp140x', 1565);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp140xbk', 1566);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp1450', 1567);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp1450bk', 1568);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp16xx', 1569);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp17xx', 1570);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2100', 1572);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2124', 1573);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2130', 1574);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2135', 1575);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp20xx', 1571);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht502', 1598);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht503', 1599);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht701', 1600);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht702', 1601);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht704', 1602);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht801', 1603);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht802', 1604);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht814', 1605);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht818', 1606);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'htx86', 1607);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wave', 'wave', 1608);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp810', 1609);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp820', 1610);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp826', 1611);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp8x6', 1612);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('groundwire', 'default', 'default', 1613);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc903', 1614);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc923', 1615);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc924', 1616);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc926', 1617);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa2102', 1618);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa3102', 1619);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa921', 1620);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa941', 1621);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa942', 1622);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linphone', 'default', 'default', 1623);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'tgp', 'tgp500', 1633);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'tgp', 'tgp550', 1634);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut113', 1635);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut123', 1636);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut133', 1637);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut136', 1638);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut670', 1639);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'utg', 'utg200b', 1640);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'utg', 'utg300b', 1641);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '3x', '3.x', 1642);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '4x', '4.x', 1643);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '5x', '5.x', 1644);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'duo', 'duo', 1648);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx101', 1660);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx150', 1661);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx1500', 1662);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx201', 1663);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx250', 1664);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx300', 1665);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx301', 1666);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx310', 1667);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx311', 1668);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx350', 1669);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx400', 1670);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx401', 1671);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx410', 1672);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx411', 1673);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx450', 1674);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx500', 1675);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx501', 1676);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx600', 1677);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx601', 1678);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'vvx', 'poly-vvx-450', 1680);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'vvx', 'poly-vvx-d230', 1681);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sipnetic', 'default', 'default', 1685);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '300', 1686);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '320', 1687);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '360', 1688);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '3xx', 1689);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '7xx', '720', 1690);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '7xx', '7xx', 1691);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '8xx', '820', 1692);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '8xx', '8xx', 1693);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'M100KLE', 1713);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'm3', 1714);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'M500KLE', 1715);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'pa', 'PA1', 1716);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'pa', 'PA1plus', 1717);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('spectralink', '', 'spectralink', 1718);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('swissvoice', 'cp25xx', 'cp2502', 1719);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('swissvoice', 'cp25xx', 'cp2505g', 1720);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('telekonnectors', 'galaxy', 'galaxy1000', 1721);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('telekonnectors', 'galaxy', 'galaxy1000-plus', 1722);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('vtech', 'vcs', 'vcs754', 1723);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'ax83x', 'ax83h', 1724);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp860', 1725);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp920', 1726);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2140', 1576);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp3240', 1582);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv300x', 1583);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3140', 1584);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3175', 1585);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3175v2', 1586);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3240', 1587);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3275', 1588);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3370', 1589);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3380', 1590);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3480', 1591);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3504', 1592);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw4004', 1593);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw4008', 1594);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw40xx', 1595);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw410x', 1596);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw42xx', 1597);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi1032', 1629);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi1062', 1630);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi302', 1631);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi310', 1632);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'edge-e', 'edge-e550', 1679);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', '650', 1645);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip321', 1649);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip331', 1650);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip335', 1651);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's300', 1682);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's500', 1683);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's700', 1684);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'c', 'C520', 1694);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'c', 'C620', 1695);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D120', 1696);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D315', 1697);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D345', 1698);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D375', 1699);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D385', 1700);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D712', 1701);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D715', 1702);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D717', 1703);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D725', 1704);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D735', 1705);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D745', 1706);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D765', 1707);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D785', 1708);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp925', 1727);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp965', 1729);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't1x', 't19p', 1730);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't20p', 1731);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't21p', 1732);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't22p', 1733);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't23g', 1734);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't23p', 1735);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't26p', 1736);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't27g', 1737);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't27p', 1738);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't28p', 1739);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't29g', 1740);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't2x', 1741);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't31g', 1742);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't32g', 1743);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't33g', 1744);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't34w', 1745);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't38g', 1746);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't40g', 1747);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't40p', 1748);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't41p', 1749);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't41s', 1750);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42g', 1751);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42s', 1752);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42u', 1753);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't43u', 1754);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't44w', 1755);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46g', 1756);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46s', 1757);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46u', 1758);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48g', 1759);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48s', 1760);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48u', 1761);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '80xx', '8030', 1647);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't49g', 1762);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't4x', 1763);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't52s', 1764);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't53', 1765);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't53w', 1766);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't54s', 1767);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't54w', 1768);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't56a', 1769);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't57w', 1770);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58a', 1771);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58v', 1772);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58w', 1773);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't5x', 1774);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'vp', 'vp530', 1775);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'vp', 'vp59', 1776);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w5x', 'w52p', 1777);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w5x', 'w56p', 1778);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w6x', 'w60b', 1779);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w7x', 'w70b', 1780);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w7x', 'w7xp', 1781);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'w8x', 'w80', 1782);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta2xx', 'ta200', 1783);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta4xx', 'ta400', 1784);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta8xx', 'ta800', 1785);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('zoiper', '5.x', '5.x', 1786);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '4xxx', '480i', 1787);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '67xx', '673x', 1788);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '67xx', '675x', 1789);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '68xx', '686x', 1790);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '91xxx', '9112i', 1791);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('aastra', '91xxx', '9133i', 1792);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('acrobits', 'default', 'default', 1793);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8103', 1794);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8180', 1795);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('algo', '81xx', '8196', 1796);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('atcom', 'agxxx', 'ag198', 1797);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '7940', 1803);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '7960', 1804);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '79x1', 1805);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8811', 1806);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8832', 1807);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8841', 1808);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8845', 1809);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8851', 1810);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8861', 1811);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '8865', 1812);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'cp', '9861', 1813);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa112', 1814);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa122', 1815);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa191', 1816);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa192', 1817);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa301', 1818);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa303', 1819);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa501g', 1820);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa502g', 1821);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa504g', 1822);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa508g', 1823);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa509g', 1824);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa512g', 1825);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa514g', 1826);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa525g', 1827);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('cisco', 'spa', 'spa525g2', 1828);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd4x', 'd40', 1829);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd5x', 'd50', 1830);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd60', 1831);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd62', 1832);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd6x', 'd65', 1833);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('digium', 'd7x', 'd70', 1834);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('escene', 'e3xx', 'e3xx', 1835);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'hx', 'h2u-v2', 1836);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'hx', 'h5', 1837);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'I', 'i30', 1838);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'vxx', 'v67', 1839);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1s', 1840);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1sg', 1841);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x1x', 'x1sp', 1842);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x2x', 'x210', 1843);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x2x', 'x2p', 1844);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3g', 1845);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sg', 1846);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sp', 1847);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3sw', 1848);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3u', 1849);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x3x', 'x3u-pro', 1850);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4', 1851);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4g', 1852);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4sg', 1853);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x4x', 'x4u', 1854);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x5x', 'x5s', 1855);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x5x', 'x5u', 1856);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x6x', 'x6', 1857);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x6x', 'x6u', 1858);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7', 1859);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7a', 1860);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('fanvil', 'x7x', 'x7c', 1861);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'audiokit', 'audiokit', 1862);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'i86x', 'i86box', 1871);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'metalbox', 'imetalbox', 1872);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10', 1873);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10g', 1874);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10lte', 1875);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10p', 1876);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p10w', 1877);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11', 1878);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11g', 1879);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11lte', 1880);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gswave', 'gswave', 1919);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht502', 1955);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht503', 1956);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht701', 1957);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht702', 1958);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht704', 1959);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht801', 1960);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht802', 1961);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht814', 1962);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'ht818', 1963);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ht', 'htx86', 1964);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wave', 'wave', 1965);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp810', 1966);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp820', 1967);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp826', 1968);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'wp', 'wp8x6', 1969);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('groundwire', 'default', 'default', 1970);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc903', 1971);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc923', 1972);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc924', 1973);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('htek', 'uc9xx', 'uc926', 1974);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa2102', 1975);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa3102', 1976);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa921', 1977);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa941', 1978);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linksys', 'spa', 'spa942', 1979);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('linphone', 'default', 'default', 1980);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'tgp', 'tgp500', 1990);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'tgp', 'tgp550', 1991);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut113', 1992);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut123', 1993);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut133', 1994);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut136', 1995);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'ut', 'ut670', 1996);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'utg', 'utg200b', 1997);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('panasonic', 'utg', 'utg300b', 1998);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '3x', '3.x', 1999);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '4x', '4.x', 2000);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '5x', '5.x', 2001);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'duo', 'duo', 2005);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx101', 2017);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx150', 2018);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx1500', 2019);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx201', 2020);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx250', 2021);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx300', 2022);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20', 1883);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20g', 1884);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33', 1895);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33g', 1896);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p33p', 1897);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p510', 1898);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p53', 1899);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p54', 1900);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p55', 1901);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p57', 1902);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p58', 1903);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp715', 1904);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp715.sm', 1905);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'dp', 'dp750', 1906);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gac', 'gac2500', 1907);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gds', 'gds3705', 1908);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gds', 'gds3710', 1909);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2612', 1911);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2612w', 1912);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2613', 1913);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2614', 1914);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2615', 1915);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp2616', 1916);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp261x', 1917);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'grp', 'grp26xx', 1918);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp110x', 1920);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp116x', 1921);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp140x', 1922);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp140xbk', 1923);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp1450', 1924);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp1450bk', 1925);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp16xx', 1926);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp17xx', 1927);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2100', 1929);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2124', 1930);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2130', 1931);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2135', 1932);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2140', 1933);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2160', 1934);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2170', 1935);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp21xx', 1936);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp21xxbk', 1937);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp3240', 1939);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv300x', 1940);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3140', 1941);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3175', 1942);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3175v2', 1943);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3240', 1944);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3275', 1945);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3370', 1946);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3380', 1947);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3480', 1948);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxv', 'gxv3504', 1949);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'ghp', 'ghp6xx', 1910);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw4004', 1950);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw4008', 1951);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw40xx', 1952);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp20xx', 1928);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2200', 1938);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw410x', 1953);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxw', 'gxw42xx', 1954);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi1032', 1986);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi1062', 1987);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi302', 1988);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('obihai', 'obi', 'obi310', 1989);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', '650', 2002);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip321', 2006);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip331', 2007);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip335', 2008);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip450', 2009);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip5000', 2010);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip550', 2011);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip560', 2012);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx301', 2023);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx310', 2024);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx311', 2025);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx350', 2026);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx400', 2027);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx401', 2028);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx410', 2029);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx411', 2030);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx450', 2031);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx500', 2032);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx501', 2033);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx600', 2034);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'vvx', 'vvx601', 2035);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'vvx', 'poly-vvx-450', 2037);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'vvx', 'poly-vvx-d230', 2038);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sipnetic', 'default', 'default', 2042);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '300', 2043);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '320', 2044);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '360', 2045);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '3xx', '3xx', 2046);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '7xx', '720', 2047);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '7xx', '7xx', 2048);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '8xx', '820', 2049);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', '8xx', '8xx', 2050);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('spectralink', '', 'spectralink', 2075);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('swissvoice', 'cp25xx', 'cp2502', 2076);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('swissvoice', 'cp25xx', 'cp2505g', 2077);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('telekonnectors', 'galaxy', 'galaxy1000', 2078);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('telekonnectors', 'galaxy', 'galaxy1000-plus', 2079);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('vtech', 'vcs', 'vcs754', 2080);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'ax83x', 'ax83h', 2081);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp860', 2082);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp920', 2083);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp925', 2084);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'cp', 'cp965', 2086);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't1x', 't19p', 2087);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't20p', 2088);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't21p', 2089);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't22p', 2090);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't23g', 2091);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't23p', 2092);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't26p', 2093);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't27g', 2094);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't27p', 2095);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't28p', 2096);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't29g', 2097);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't2x', 't2x', 2098);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't31g', 2099);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't32g', 2100);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't33g', 2101);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't34w', 2102);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't3x', 't38g', 2103);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't40g', 2104);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't40p', 2105);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't41p', 2106);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't41s', 2107);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42g', 2108);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42s', 2109);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't42u', 2110);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't43u', 2111);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't44w', 2112);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '6x', '6.x', 2003);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46g', 2113);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46s', 2114);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't46u', 2115);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48g', 2116);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48s', 2117);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't48u', 2118);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't49g', 2119);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't4x', 't4x', 2120);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't52s', 2121);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't53', 2122);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't53w', 2123);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't54s', 2124);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't54w', 2125);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't56a', 2126);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't57w', 2127);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58a', 2128);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58v', 2129);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't58w', 2130);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't5x', 't5x', 2131);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'vp', 'vp530', 2132);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 'vp', 'vp59', 2133);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta2xx', 'ta200', 2140);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta4xx', 'ta400', 2141);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yeastar', 'ta8xx', 'ta800', 2142);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('zoiper', '5.x', '5.x', 2143);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip10', 1506);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip11c', 1507);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip12wp', 1508);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip13g', 1509);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip14g', 1510);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip15g', 1511);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip16', 1512);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip16plus', 1513);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip10', 1863);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip11c', 1864);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip12wp', 1865);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip13g', 1866);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip14g', 1867);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip15g', 1868);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip16', 1869);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'fip', 'fip16plus', 1870);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11w', 1525);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11p', 1881);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p11w', 1882);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p23gw', 1536);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p24gw', 1537);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20p', 1885);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p20w', 1886);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21', 1887);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21p', 1888);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p21w', 1889);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p22g', 1890);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p22p', 1891);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p23g', 1892);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p23gw', 1893);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('flyingvoice', 'p', 'p24gw', 1894);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2200', 1581);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2160', 1577);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp2170', 1578);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's300', 2039);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's500', 2040);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('sangoma', 's', 's700', 2041);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'c', 'C520', 2051);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'c', 'C620', 2052);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'PA', 'PA1', 2073);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'PA', 'PA1plus', 2074);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'M100KLE', 2070);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D120', 2053);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'm3', 2071);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'm', 'M500KLE', 2072);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp21xx', 1579);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('grandstream', 'gxp', 'gxp21xxbk', 1580);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('poly', 'edge-e', 'edge-e550', 2036);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip450', 1652);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip5000', 1653);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip550', 1654);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip560', 1655);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip6000', 1656);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip650', 1657);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip670', 1658);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip7000', 1659);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip6000', 2013);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip650', 2014);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip670', 2015);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', 'ip', 'ip7000', 2016);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D812', 1709);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D815', 1710);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D862', 1711);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D865', 1712);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D315', 2054);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D345', 2055);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D375', 2056);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D385', 2057);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D712', 2058);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D715', 2059);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D717', 2060);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D725', 2061);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D735', 2062);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D745', 2063);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D765', 2064);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D785', 2065);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D812', 2066);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D815', 2067);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D862', 2068);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('snom', 'd', 'D865', 2069);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('swissvoice', 'cp8xx', 'cp860', 2145);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '6x', '6.x', 1646);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('polycom', '80xx', '8030', 2004);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('avaya', 'j100', 'j100S', 1441);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('avaya', 'j100', 'j139', 1442);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('avaya', 'j100', 'j169', 1443);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('avaya', 'j100', 'j179', 1444);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('avaya', 'j100', 'j189', 1445);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('portsip', 'qr', 'phone', 2146);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5320e', 1624);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5324', 1625);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5330', 1626);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5330e', 1627);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5320e', 1981);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5324', 1982);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5330', 1983);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5330e', 1984);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5340', 1985);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('mitel', '53xx', '5340', 1628);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't7x', 't73w', 3211);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't7x', 't74u', 3212);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't7x', 't74w', 3213);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't7x', 't77u', 3214);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't8x', 't85w', 3215);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't8x', 't87w', 3216);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't8x', 't88v', 3217);
INSERT INTO public.models OVERRIDING SYSTEM VALUE VALUES ('yealink', 't8x', 't88w', 3218);


--
-- Name: models_id_seq; Type: SEQUENCE SET; Schema: public; Owner: provisioner
--

SELECT pg_catalog.setval('public.models_id_seq', 2146, true);


--
-- Name: provisioner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: provisioner
--

SELECT pg_catalog.setval('public.provisioner_id_seq', 61, true);


--
-- Name: models models_pk; Type: CONSTRAINT; Schema: public; Owner: provisioner
--

ALTER TABLE ONLY public.models
    ADD CONSTRAINT models_pk PRIMARY KEY (id);


--
-- Name: brands provisioner_pk; Type: CONSTRAINT; Schema: public; Owner: provisioner
--

ALTER TABLE ONLY public.brands
    ADD CONSTRAINT provisioner_pk PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

\unrestrict tbVWK1WpKUFDG4ZN0ylpqAuyciVRfuwWiVt825fcPnFR0dsERHWVFydOo0B8Lyk

