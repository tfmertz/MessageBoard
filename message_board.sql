--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: messages; Type: TABLE; Schema: public; Owner: tom; Tablespace: 
--

CREATE TABLE messages (
    id integer NOT NULL,
    message character varying,
    created timestamp without time zone,
    user_id integer
);


ALTER TABLE public.messages OWNER TO tom;

--
-- Name: messages_id_seq; Type: SEQUENCE; Schema: public; Owner: tom
--

CREATE SEQUENCE messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.messages_id_seq OWNER TO tom;

--
-- Name: messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tom
--

ALTER SEQUENCE messages_id_seq OWNED BY messages.id;


--
-- Name: messages_tags; Type: TABLE; Schema: public; Owner: tom; Tablespace: 
--

CREATE TABLE messages_tags (
    id integer NOT NULL,
    message_id integer,
    tag_id integer
);


ALTER TABLE public.messages_tags OWNER TO tom;

--
-- Name: messages_tags_id_seq; Type: SEQUENCE; Schema: public; Owner: tom
--

CREATE SEQUENCE messages_tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.messages_tags_id_seq OWNER TO tom;

--
-- Name: messages_tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tom
--

ALTER SEQUENCE messages_tags_id_seq OWNED BY messages_tags.id;


--
-- Name: tags; Type: TABLE; Schema: public; Owner: tom; Tablespace: 
--

CREATE TABLE tags (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE public.tags OWNER TO tom;

--
-- Name: tags_id_seq; Type: SEQUENCE; Schema: public; Owner: tom
--

CREATE SEQUENCE tags_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tags_id_seq OWNER TO tom;

--
-- Name: tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tom
--

ALTER SEQUENCE tags_id_seq OWNED BY tags.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: tom; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    name character varying,
    password character varying,
    admin boolean
);


ALTER TABLE public.users OWNER TO tom;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: tom
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO tom;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: tom
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: tom
--

ALTER TABLE ONLY messages ALTER COLUMN id SET DEFAULT nextval('messages_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: tom
--

ALTER TABLE ONLY messages_tags ALTER COLUMN id SET DEFAULT nextval('messages_tags_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: tom
--

ALTER TABLE ONLY tags ALTER COLUMN id SET DEFAULT nextval('tags_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: tom
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: messages; Type: TABLE DATA; Schema: public; Owner: tom
--

COPY messages (id, message, created, user_id) FROM stdin;
19	Going out to Mi Mero Mole at 5pm if anyone wants to come!	2015-05-16 17:26:42	4
20	Multnomah Falls this weekend if anyone is interested? Give me a call 717-123-45678!	2015-05-16 17:28:01	4
21	Going to Phase2 for the Sass meet up, who's in? It starts a 7pm, normally pizza and beer with a lot of companies looking to hire...	2015-05-16 17:28:56	2
\.


--
-- Name: messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tom
--

SELECT pg_catalog.setval('messages_id_seq', 21, true);


--
-- Data for Name: messages_tags; Type: TABLE DATA; Schema: public; Owner: tom
--

COPY messages_tags (id, message_id, tag_id) FROM stdin;
1	1	2
2	2	1
3	3	3
4	4	1
5	5	1
6	6	2
7	7	4
8	8	1
9	9	2
10	10	3
11	11	1
12	12	2
13	13	3
14	14	1
15	15	1
16	16	1
17	17	2
18	18	3
19	19	1
20	20	4
21	21	2
\.


--
-- Name: messages_tags_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tom
--

SELECT pg_catalog.setval('messages_tags_id_seq', 21, true);


--
-- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: tom
--

COPY tags (id, name) FROM stdin;
1	Bar
2	Meet up
3	Work meeting
4	Hiking
\.


--
-- Name: tags_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tom
--

SELECT pg_catalog.setval('tags_id_seq', 4, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: tom
--

COPY users (id, name, password, admin) FROM stdin;
1	dad123	thomas	f
2	thomas	thomas12	f
3	Let'sss	123456	f
4	amberg	amberg	f
5	esbon599	$2y$10$PLA54.1IRACsRWTw8NdsXeDHVpNiOvS9M5AysbI2ZnZkDV9782.0i	f
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: tom
--

SELECT pg_catalog.setval('users_id_seq', 5, true);


--
-- Name: messages_pkey; Type: CONSTRAINT; Schema: public; Owner: tom; Tablespace: 
--

ALTER TABLE ONLY messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id);


--
-- Name: messages_tags_pkey; Type: CONSTRAINT; Schema: public; Owner: tom; Tablespace: 
--

ALTER TABLE ONLY messages_tags
    ADD CONSTRAINT messages_tags_pkey PRIMARY KEY (id);


--
-- Name: tags_pkey; Type: CONSTRAINT; Schema: public; Owner: tom; Tablespace: 
--

ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: tom; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

