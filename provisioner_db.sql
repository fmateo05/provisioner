--
-- PostgreSQL database dump
--

\restrict oEB8jZXlG52DpCiWcbPbtX1pXBWWR2nnNQIdTh0LSgSBqyw6lBZxBiJ812An6Py

-- Dumped from database version 13.22
-- Dumped by pg_dump version 13.22

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

COPY public.brands (id, brand, family, model) FROM stdin;
1	aastra	\N	\N
2	acrobits	\N	\N
3	algo	\N	\N
4	atcom	\N	\N
5	avaya	\N	\N
6	cisco	\N	\N
7	digium	\N	\N
8	escene	\N	\N
9	fanvil	\N	\N
10	flyingvoice	\N	\N
11	grandstream	\N	\N
12	groundwire	\N	\N
13	htek	\N	\N
14	linksys	\N	\N
15	linphone	\N	\N
16	mitel	\N	\N
17	obihai	\N	\N
18	panasonic	\N	\N
19	poly	\N	\N
20	polycom	\N	\N
21	sangoma	\N	\N
22	sipnetic	\N	\N
23	snom	\N	\N
24	spectralink	\N	\N
25	swissvoice	\N	\N
26	telekonnectors	\N	\N
27	vtech	\N	\N
28	yealink	\N	\N
29	yeastar	\N	\N
30	zoiper	\N	\N
61	portsip	\N	\N
\.


--
-- Data for Name: models; Type: TABLE DATA; Schema: public; Owner: provisioner
--

COPY public.models (brand, family, model, id) FROM stdin;
aastra	4xxx	480i	1430
aastra	67xx	673x	1431
aastra	67xx	675x	1432
aastra	68xx	686x	1433
aastra	91xxx	9112i	1434
aastra	91xxx	9133i	1435
acrobits	default	default	1436
algo	81xx	8103	1437
algo	81xx	8180	1438
algo	81xx	8196	1439
atcom	agxxx	ag198	1440
cisco	cp	7940	1446
cisco	cp	7960	1447
cisco	cp	79x1	1448
cisco	cp	8811	1449
cisco	cp	8832	1450
cisco	cp	8841	1451
cisco	cp	8845	1452
cisco	cp	8851	1453
cisco	cp	8861	1454
cisco	cp	8865	1455
cisco	cp	9861	1456
cisco	spa	spa112	1457
cisco	spa	spa122	1458
cisco	spa	spa191	1459
cisco	spa	spa192	1460
cisco	spa	spa301	1461
cisco	spa	spa303	1462
cisco	spa	spa501g	1463
cisco	spa	spa502g	1464
cisco	spa	spa504g	1465
cisco	spa	spa508g	1466
cisco	spa	spa509g	1467
cisco	spa	spa512g	1468
cisco	spa	spa514g	1469
cisco	spa	spa525g	1470
cisco	spa	spa525g2	1471
digium	d4x	d40	1472
digium	d5x	d50	1473
digium	d6x	d60	1474
digium	d6x	d62	1475
digium	d6x	d65	1476
digium	d7x	d70	1477
escene	e3xx	e3xx	1478
fanvil	hx	h2u-v2	1479
fanvil	hx	h5	1480
fanvil	I	i30	1481
fanvil	vxx	v67	1482
fanvil	x1x	x1s	1483
fanvil	x1x	x1sg	1484
fanvil	x1x	x1sp	1485
fanvil	x2x	x210	1486
fanvil	x2x	x2p	1487
fanvil	x3x	x3g	1488
fanvil	x3x	x3sg	1489
fanvil	x3x	x3sp	1490
fanvil	x3x	x3sw	1491
fanvil	x3x	x3u	1492
fanvil	x3x	x3u-pro	1493
fanvil	x4x	x4	1494
fanvil	x4x	x4g	1495
fanvil	x4x	x4sg	1496
fanvil	x4x	x4u	1497
fanvil	x5x	x5s	1498
fanvil	x5x	x5u	1499
fanvil	x6x	x6	1500
fanvil	x6x	x6u	1501
fanvil	x7x	x7	1502
fanvil	x7x	x7a	1503
fanvil	x7x	x7c	1504
flyingvoice	audiokit	audiokit	1505
flyingvoice	i86x	i86box	1514
flyingvoice	metalbox	imetalbox	1515
grandstream	gswave	gswave	1562
flyingvoice	p	p10	1516
flyingvoice	p	p10g	1517
flyingvoice	p	p10lte	1518
flyingvoice	p	p10p	1519
flyingvoice	p	p10w	1520
flyingvoice	p	p11	1521
flyingvoice	p	p11g	1522
flyingvoice	p	p11lte	1523
flyingvoice	p	p11p	1524
flyingvoice	p	p20	1526
flyingvoice	p	p20g	1527
flyingvoice	p	p20p	1528
flyingvoice	p	p20w	1529
flyingvoice	p	p21	1530
flyingvoice	p	p21p	1531
flyingvoice	p	p21w	1532
flyingvoice	p	p22g	1533
flyingvoice	p	p22p	1534
flyingvoice	p	p23g	1535
flyingvoice	p	p33	1538
flyingvoice	p	p33g	1539
flyingvoice	p	p33p	1540
flyingvoice	p	p510	1541
flyingvoice	p	p53	1542
flyingvoice	p	p54	1543
flyingvoice	p	p55	1544
flyingvoice	p	p57	1545
flyingvoice	p	p58	1546
grandstream	dp	dp715	1547
grandstream	dp	dp715.sm	1548
grandstream	dp	dp750	1549
grandstream	gac	gac2500	1550
grandstream	gds	gds3705	1551
grandstream	gds	gds3710	1552
grandstream	ghp	ghp6xx	1553
grandstream	grp	grp2612	1554
grandstream	grp	grp2612w	1555
grandstream	grp	grp2613	1556
grandstream	grp	grp2614	1557
grandstream	grp	grp2615	1558
grandstream	grp	grp2616	1559
grandstream	grp	grp261x	1560
grandstream	grp	grp26xx	1561
grandstream	gxp	gxp110x	1563
grandstream	gxp	gxp116x	1564
grandstream	gxp	gxp140x	1565
grandstream	gxp	gxp140xbk	1566
grandstream	gxp	gxp1450	1567
grandstream	gxp	gxp1450bk	1568
grandstream	gxp	gxp16xx	1569
grandstream	gxp	gxp17xx	1570
grandstream	gxp	gxp2100	1572
grandstream	gxp	gxp2124	1573
grandstream	gxp	gxp2130	1574
grandstream	gxp	gxp2135	1575
grandstream	gxp	gxp20xx	1571
grandstream	ht	ht502	1598
grandstream	ht	ht503	1599
grandstream	ht	ht701	1600
grandstream	ht	ht702	1601
grandstream	ht	ht704	1602
grandstream	ht	ht801	1603
grandstream	ht	ht802	1604
grandstream	ht	ht814	1605
grandstream	ht	ht818	1606
grandstream	ht	htx86	1607
grandstream	wave	wave	1608
grandstream	wp	wp810	1609
grandstream	wp	wp820	1610
grandstream	wp	wp826	1611
grandstream	wp	wp8x6	1612
groundwire	default	default	1613
htek	uc9xx	uc903	1614
htek	uc9xx	uc923	1615
htek	uc9xx	uc924	1616
htek	uc9xx	uc926	1617
linksys	spa	spa2102	1618
linksys	spa	spa3102	1619
linksys	spa	spa921	1620
linksys	spa	spa941	1621
linksys	spa	spa942	1622
linphone	default	default	1623
panasonic	tgp	tgp500	1633
panasonic	tgp	tgp550	1634
panasonic	ut	ut113	1635
panasonic	ut	ut123	1636
panasonic	ut	ut133	1637
panasonic	ut	ut136	1638
panasonic	ut	ut670	1639
panasonic	utg	utg200b	1640
panasonic	utg	utg300b	1641
polycom	3x	3.x	1642
polycom	4x	4.x	1643
polycom	5x	5.x	1644
polycom	duo	duo	1648
polycom	vvx	vvx101	1660
polycom	vvx	vvx150	1661
polycom	vvx	vvx1500	1662
polycom	vvx	vvx201	1663
polycom	vvx	vvx250	1664
polycom	vvx	vvx300	1665
polycom	vvx	vvx301	1666
polycom	vvx	vvx310	1667
polycom	vvx	vvx311	1668
polycom	vvx	vvx350	1669
polycom	vvx	vvx400	1670
polycom	vvx	vvx401	1671
polycom	vvx	vvx410	1672
polycom	vvx	vvx411	1673
polycom	vvx	vvx450	1674
polycom	vvx	vvx500	1675
polycom	vvx	vvx501	1676
polycom	vvx	vvx600	1677
polycom	vvx	vvx601	1678
poly	vvx	poly-vvx-450	1680
poly	vvx	poly-vvx-d230	1681
sipnetic	default	default	1685
snom	3xx	300	1686
snom	3xx	320	1687
snom	3xx	360	1688
snom	3xx	3xx	1689
snom	7xx	720	1690
snom	7xx	7xx	1691
snom	8xx	820	1692
snom	8xx	8xx	1693
snom	m	M100KLE	1713
snom	m	m3	1714
snom	m	M500KLE	1715
snom	pa	PA1	1716
snom	pa	PA1plus	1717
spectralink		spectralink	1718
swissvoice	cp25xx	cp2502	1719
swissvoice	cp25xx	cp2505g	1720
telekonnectors	galaxy	galaxy1000	1721
telekonnectors	galaxy	galaxy1000-plus	1722
vtech	vcs	vcs754	1723
yealink	ax83x	ax83h	1724
yealink	cp	cp860	1725
yealink	cp	cp920	1726
grandstream	gxp	gxp2140	1576
grandstream	gxp	gxp3240	1582
grandstream	gxv	gxv300x	1583
grandstream	gxv	gxv3140	1584
grandstream	gxv	gxv3175	1585
grandstream	gxv	gxv3175v2	1586
grandstream	gxv	gxv3240	1587
grandstream	gxv	gxv3275	1588
grandstream	gxv	gxv3370	1589
grandstream	gxv	gxv3380	1590
grandstream	gxv	gxv3480	1591
grandstream	gxv	gxv3504	1592
grandstream	gxw	gxw4004	1593
grandstream	gxw	gxw4008	1594
grandstream	gxw	gxw40xx	1595
grandstream	gxw	gxw410x	1596
grandstream	gxw	gxw42xx	1597
mitel	mitel	5320e	1624
mitel	mitel	5324	1625
mitel	mitel	5330	1626
mitel	mitel	5330e	1627
obihai	obi	obi1032	1629
obihai	obi	obi1062	1630
obihai	obi	obi302	1631
obihai	obi	obi310	1632
poly	edge-e	edge-e550	1679
polycom	ip	650	1645
polycom	ip	ip321	1649
polycom	ip	ip331	1650
polycom	ip	ip335	1651
sangoma	s	s300	1682
sangoma	s	s500	1683
sangoma	s	s700	1684
snom	c	C520	1694
snom	c	C620	1695
snom	d	D120	1696
snom	d	D315	1697
snom	d	D345	1698
snom	d	D375	1699
snom	d	D385	1700
snom	d	D712	1701
snom	d	D715	1702
snom	d	D717	1703
snom	d	D725	1704
snom	d	D735	1705
snom	d	D745	1706
snom	d	D765	1707
snom	d	D785	1708
yealink	cp	cp925	1727
yealink	cp	cp965	1729
yealink	t1x	t19p	1730
yealink	t2x	t20p	1731
yealink	t2x	t21p	1732
yealink	t2x	t22p	1733
yealink	t2x	t23g	1734
yealink	t2x	t23p	1735
yealink	t2x	t26p	1736
yealink	t2x	t27g	1737
yealink	t2x	t27p	1738
yealink	t2x	t28p	1739
yealink	t2x	t29g	1740
yealink	t2x	t2x	1741
yealink	t3x	t31g	1742
yealink	t3x	t32g	1743
yealink	t3x	t33g	1744
yealink	t3x	t34w	1745
yealink	t3x	t38g	1746
yealink	t4x	t40g	1747
yealink	t4x	t40p	1748
yealink	t4x	t41p	1749
yealink	t4x	t41s	1750
yealink	t4x	t42g	1751
yealink	t4x	t42s	1752
yealink	t4x	t42u	1753
yealink	t4x	t43u	1754
yealink	t4x	t44w	1755
yealink	t4x	t46g	1756
yealink	t4x	t46s	1757
yealink	t4x	t46u	1758
yealink	t4x	t48g	1759
yealink	t4x	t48s	1760
yealink	t4x	t48u	1761
polycom	80xx	8030	1647
yealink	t4x	t49g	1762
yealink	t4x	t4x	1763
yealink	t5x	t52s	1764
yealink	t5x	t53	1765
yealink	t5x	t53w	1766
yealink	t5x	t54s	1767
yealink	t5x	t54w	1768
yealink	t5x	t56a	1769
yealink	t5x	t57w	1770
yealink	t5x	t58a	1771
yealink	t5x	t58v	1772
yealink	t5x	t58w	1773
yealink	t5x	t5x	1774
yealink	vp	vp530	1775
yealink	vp	vp59	1776
yealink	w5x	w52p	1777
yealink	w5x	w56p	1778
yealink	w6x	w60b	1779
yealink	w7x	w70b	1780
yealink	w7x	w7xp	1781
yealink	w8x	w80	1782
yeastar	ta2xx	ta200	1783
yeastar	ta4xx	ta400	1784
yeastar	ta8xx	ta800	1785
zoiper	5.x	5.x	1786
aastra	4xxx	480i	1787
aastra	67xx	673x	1788
aastra	67xx	675x	1789
aastra	68xx	686x	1790
aastra	91xxx	9112i	1791
aastra	91xxx	9133i	1792
acrobits	default	default	1793
algo	81xx	8103	1794
algo	81xx	8180	1795
algo	81xx	8196	1796
atcom	agxxx	ag198	1797
cisco	cp	7940	1803
cisco	cp	7960	1804
cisco	cp	79x1	1805
cisco	cp	8811	1806
cisco	cp	8832	1807
cisco	cp	8841	1808
cisco	cp	8845	1809
cisco	cp	8851	1810
cisco	cp	8861	1811
cisco	cp	8865	1812
cisco	cp	9861	1813
cisco	spa	spa112	1814
cisco	spa	spa122	1815
cisco	spa	spa191	1816
cisco	spa	spa192	1817
cisco	spa	spa301	1818
cisco	spa	spa303	1819
cisco	spa	spa501g	1820
cisco	spa	spa502g	1821
cisco	spa	spa504g	1822
cisco	spa	spa508g	1823
cisco	spa	spa509g	1824
cisco	spa	spa512g	1825
cisco	spa	spa514g	1826
cisco	spa	spa525g	1827
cisco	spa	spa525g2	1828
digium	d4x	d40	1829
digium	d5x	d50	1830
digium	d6x	d60	1831
digium	d6x	d62	1832
digium	d6x	d65	1833
digium	d7x	d70	1834
escene	e3xx	e3xx	1835
fanvil	hx	h2u-v2	1836
fanvil	hx	h5	1837
fanvil	I	i30	1838
fanvil	vxx	v67	1839
fanvil	x1x	x1s	1840
fanvil	x1x	x1sg	1841
fanvil	x1x	x1sp	1842
fanvil	x2x	x210	1843
fanvil	x2x	x2p	1844
fanvil	x3x	x3g	1845
fanvil	x3x	x3sg	1846
fanvil	x3x	x3sp	1847
fanvil	x3x	x3sw	1848
fanvil	x3x	x3u	1849
fanvil	x3x	x3u-pro	1850
fanvil	x4x	x4	1851
fanvil	x4x	x4g	1852
fanvil	x4x	x4sg	1853
fanvil	x4x	x4u	1854
fanvil	x5x	x5s	1855
fanvil	x5x	x5u	1856
fanvil	x6x	x6	1857
fanvil	x6x	x6u	1858
fanvil	x7x	x7	1859
fanvil	x7x	x7a	1860
fanvil	x7x	x7c	1861
flyingvoice	audiokit	audiokit	1862
flyingvoice	i86x	i86box	1871
flyingvoice	metalbox	imetalbox	1872
flyingvoice	p	p10	1873
flyingvoice	p	p10g	1874
flyingvoice	p	p10lte	1875
flyingvoice	p	p10p	1876
flyingvoice	p	p10w	1877
flyingvoice	p	p11	1878
flyingvoice	p	p11g	1879
flyingvoice	p	p11lte	1880
grandstream	gswave	gswave	1919
grandstream	ht	ht502	1955
grandstream	ht	ht503	1956
grandstream	ht	ht701	1957
grandstream	ht	ht702	1958
grandstream	ht	ht704	1959
grandstream	ht	ht801	1960
grandstream	ht	ht802	1961
grandstream	ht	ht814	1962
grandstream	ht	ht818	1963
grandstream	ht	htx86	1964
grandstream	wave	wave	1965
grandstream	wp	wp810	1966
grandstream	wp	wp820	1967
grandstream	wp	wp826	1968
grandstream	wp	wp8x6	1969
groundwire	default	default	1970
htek	uc9xx	uc903	1971
htek	uc9xx	uc923	1972
htek	uc9xx	uc924	1973
htek	uc9xx	uc926	1974
linksys	spa	spa2102	1975
linksys	spa	spa3102	1976
linksys	spa	spa921	1977
linksys	spa	spa941	1978
linksys	spa	spa942	1979
linphone	default	default	1980
panasonic	tgp	tgp500	1990
panasonic	tgp	tgp550	1991
panasonic	ut	ut113	1992
panasonic	ut	ut123	1993
panasonic	ut	ut133	1994
panasonic	ut	ut136	1995
panasonic	ut	ut670	1996
panasonic	utg	utg200b	1997
panasonic	utg	utg300b	1998
polycom	3x	3.x	1999
polycom	4x	4.x	2000
polycom	5x	5.x	2001
polycom	duo	duo	2005
polycom	vvx	vvx101	2017
polycom	vvx	vvx150	2018
polycom	vvx	vvx1500	2019
polycom	vvx	vvx201	2020
polycom	vvx	vvx250	2021
polycom	vvx	vvx300	2022
flyingvoice	p	p20	1883
flyingvoice	p	p20g	1884
flyingvoice	p	p33	1895
flyingvoice	p	p33g	1896
flyingvoice	p	p33p	1897
flyingvoice	p	p510	1898
flyingvoice	p	p53	1899
flyingvoice	p	p54	1900
flyingvoice	p	p55	1901
flyingvoice	p	p57	1902
flyingvoice	p	p58	1903
grandstream	dp	dp715	1904
grandstream	dp	dp715.sm	1905
grandstream	dp	dp750	1906
grandstream	gac	gac2500	1907
grandstream	gds	gds3705	1908
grandstream	gds	gds3710	1909
grandstream	grp	grp2612	1911
grandstream	grp	grp2612w	1912
grandstream	grp	grp2613	1913
grandstream	grp	grp2614	1914
grandstream	grp	grp2615	1915
grandstream	grp	grp2616	1916
grandstream	grp	grp261x	1917
grandstream	grp	grp26xx	1918
grandstream	gxp	gxp110x	1920
grandstream	gxp	gxp116x	1921
grandstream	gxp	gxp140x	1922
grandstream	gxp	gxp140xbk	1923
grandstream	gxp	gxp1450	1924
grandstream	gxp	gxp1450bk	1925
grandstream	gxp	gxp16xx	1926
grandstream	gxp	gxp17xx	1927
grandstream	gxp	gxp2100	1929
grandstream	gxp	gxp2124	1930
grandstream	gxp	gxp2130	1931
grandstream	gxp	gxp2135	1932
grandstream	gxp	gxp2140	1933
grandstream	gxp	gxp2160	1934
grandstream	gxp	gxp2170	1935
grandstream	gxp	gxp21xx	1936
grandstream	gxp	gxp21xxbk	1937
grandstream	gxp	gxp3240	1939
grandstream	gxv	gxv300x	1940
grandstream	gxv	gxv3140	1941
grandstream	gxv	gxv3175	1942
grandstream	gxv	gxv3175v2	1943
grandstream	gxv	gxv3240	1944
grandstream	gxv	gxv3275	1945
grandstream	gxv	gxv3370	1946
grandstream	gxv	gxv3380	1947
grandstream	gxv	gxv3480	1948
grandstream	gxv	gxv3504	1949
grandstream	ghp	ghp6xx	1910
grandstream	gxw	gxw4004	1950
grandstream	gxw	gxw4008	1951
grandstream	gxw	gxw40xx	1952
grandstream	gxp	gxp20xx	1928
grandstream	gxp	gxp2200	1938
grandstream	gxw	gxw410x	1953
grandstream	gxw	gxw42xx	1954
mitel	mitel	5320e	1981
mitel	mitel	5324	1982
mitel	mitel	5330	1983
mitel	mitel	5330e	1984
mitel	mitel	5340	1985
obihai	obi	obi1032	1986
obihai	obi	obi1062	1987
obihai	obi	obi302	1988
obihai	obi	obi310	1989
polycom	ip	650	2002
polycom	ip	ip321	2006
polycom	ip	ip331	2007
polycom	ip	ip335	2008
polycom	ip	ip450	2009
polycom	ip	ip5000	2010
polycom	ip	ip550	2011
polycom	ip	ip560	2012
polycom	vvx	vvx301	2023
polycom	vvx	vvx310	2024
polycom	vvx	vvx311	2025
polycom	vvx	vvx350	2026
polycom	vvx	vvx400	2027
polycom	vvx	vvx401	2028
polycom	vvx	vvx410	2029
polycom	vvx	vvx411	2030
polycom	vvx	vvx450	2031
polycom	vvx	vvx500	2032
polycom	vvx	vvx501	2033
polycom	vvx	vvx600	2034
polycom	vvx	vvx601	2035
poly	vvx	poly-vvx-450	2037
poly	vvx	poly-vvx-d230	2038
sipnetic	default	default	2042
snom	3xx	300	2043
snom	3xx	320	2044
snom	3xx	360	2045
snom	3xx	3xx	2046
snom	7xx	720	2047
snom	7xx	7xx	2048
snom	8xx	820	2049
snom	8xx	8xx	2050
spectralink		spectralink	2075
swissvoice	cp25xx	cp2502	2076
swissvoice	cp25xx	cp2505g	2077
telekonnectors	galaxy	galaxy1000	2078
telekonnectors	galaxy	galaxy1000-plus	2079
vtech	vcs	vcs754	2080
yealink	ax83x	ax83h	2081
yealink	cp	cp860	2082
yealink	cp	cp920	2083
yealink	cp	cp925	2084
yealink	cp	cp965	2086
yealink	t1x	t19p	2087
yealink	t2x	t20p	2088
yealink	t2x	t21p	2089
yealink	t2x	t22p	2090
yealink	t2x	t23g	2091
yealink	t2x	t23p	2092
yealink	t2x	t26p	2093
yealink	t2x	t27g	2094
yealink	t2x	t27p	2095
yealink	t2x	t28p	2096
yealink	t2x	t29g	2097
yealink	t2x	t2x	2098
yealink	t3x	t31g	2099
yealink	t3x	t32g	2100
yealink	t3x	t33g	2101
yealink	t3x	t34w	2102
yealink	t3x	t38g	2103
yealink	t4x	t40g	2104
yealink	t4x	t40p	2105
yealink	t4x	t41p	2106
yealink	t4x	t41s	2107
yealink	t4x	t42g	2108
yealink	t4x	t42s	2109
yealink	t4x	t42u	2110
yealink	t4x	t43u	2111
yealink	t4x	t44w	2112
polycom	6x	6.x	2003
yealink	t4x	t46g	2113
yealink	t4x	t46s	2114
yealink	t4x	t46u	2115
yealink	t4x	t48g	2116
yealink	t4x	t48s	2117
yealink	t4x	t48u	2118
yealink	t4x	t49g	2119
yealink	t4x	t4x	2120
yealink	t5x	t52s	2121
yealink	t5x	t53	2122
yealink	t5x	t53w	2123
yealink	t5x	t54s	2124
yealink	t5x	t54w	2125
yealink	t5x	t56a	2126
yealink	t5x	t57w	2127
yealink	t5x	t58a	2128
yealink	t5x	t58v	2129
yealink	t5x	t58w	2130
yealink	t5x	t5x	2131
yealink	vp	vp530	2132
yealink	vp	vp59	2133
yeastar	ta2xx	ta200	2140
yeastar	ta4xx	ta400	2141
yeastar	ta8xx	ta800	2142
zoiper	5.x	5.x	2143
flyingvoice	fip	fip10	1506
flyingvoice	fip	fip11c	1507
flyingvoice	fip	fip12wp	1508
flyingvoice	fip	fip13g	1509
flyingvoice	fip	fip14g	1510
flyingvoice	fip	fip15g	1511
flyingvoice	fip	fip16	1512
flyingvoice	fip	fip16plus	1513
flyingvoice	fip	fip10	1863
flyingvoice	fip	fip11c	1864
flyingvoice	fip	fip12wp	1865
flyingvoice	fip	fip13g	1866
flyingvoice	fip	fip14g	1867
flyingvoice	fip	fip15g	1868
flyingvoice	fip	fip16	1869
flyingvoice	fip	fip16plus	1870
flyingvoice	p	p11w	1525
flyingvoice	p	p11p	1881
flyingvoice	p	p11w	1882
flyingvoice	p	p23gw	1536
flyingvoice	p	p24gw	1537
flyingvoice	p	p20p	1885
flyingvoice	p	p20w	1886
flyingvoice	p	p21	1887
flyingvoice	p	p21p	1888
flyingvoice	p	p21w	1889
flyingvoice	p	p22g	1890
flyingvoice	p	p22p	1891
flyingvoice	p	p23g	1892
flyingvoice	p	p23gw	1893
flyingvoice	p	p24gw	1894
grandstream	gxp	gxp2200	1581
grandstream	gxp	gxp2160	1577
grandstream	gxp	gxp2170	1578
sangoma	s	s300	2039
sangoma	s	s500	2040
sangoma	s	s700	2041
snom	c	C520	2051
snom	c	C620	2052
snom	PA	PA1	2073
snom	PA	PA1plus	2074
snom	m	M100KLE	2070
snom	d	D120	2053
snom	m	m3	2071
snom	m	M500KLE	2072
grandstream	gxp	gxp21xx	1579
grandstream	gxp	gxp21xxbk	1580
mitel	mitel	5340	1628
poly	edge-e	edge-e550	2036
polycom	ip	ip450	1652
polycom	ip	ip5000	1653
polycom	ip	ip550	1654
polycom	ip	ip560	1655
polycom	ip	ip6000	1656
polycom	ip	ip650	1657
polycom	ip	ip670	1658
polycom	ip	ip7000	1659
polycom	ip	ip6000	2013
polycom	ip	ip650	2014
polycom	ip	ip670	2015
polycom	ip	ip7000	2016
snom	d	D812	1709
snom	d	D815	1710
snom	d	D862	1711
snom	d	D865	1712
snom	d	D315	2054
snom	d	D345	2055
snom	d	D375	2056
snom	d	D385	2057
snom	d	D712	2058
snom	d	D715	2059
snom	d	D717	2060
snom	d	D725	2061
snom	d	D735	2062
snom	d	D745	2063
snom	d	D765	2064
snom	d	D785	2065
snom	d	D812	2066
snom	d	D815	2067
snom	d	D862	2068
snom	d	D865	2069
swissvoice	cp8xx	cp860	2145
polycom	6x	6.x	1646
polycom	80xx	8030	2004
yealink	t	t73w	3211
yealink	t	t74u	3212
yealink	t	t74w	3213
yealink	t	t77u	3214
yealink	t	t85w	3215
yealink	t	t87w	3216
yealink	t	t88v	3217
yealink	t	t88w	3218
avaya	j100	j100S	1441
avaya	j100	j139	1442
avaya	j100	j169	1443
avaya	j100	j179	1444
avaya	j100	j189	1445
portsip	qr	phone	2146
\.


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

\unrestrict oEB8jZXlG52DpCiWcbPbtX1pXBWWR2nnNQIdTh0LSgSBqyw6lBZxBiJ812An6Py

