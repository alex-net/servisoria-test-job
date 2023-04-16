--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

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

DROP INDEX public."questions-sex-ind";
DROP INDEX public."questions-region-ind";
DROP INDEX public."questions-rate-ind";
DROP INDEX public."questions-phone-ind";
DROP INDEX public."questions-name-ind";
DROP INDEX public."questions-email-ind";
DROP INDEX public."questions-date-ind";
DROP INDEX public."questions-comment-ind";
DROP INDEX public."questions-city-ind";
ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_pkey;
ALTER TABLE ONLY public.migration DROP CONSTRAINT migration_pkey;
ALTER TABLE public.questions ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE public.questions_id_seq;
DROP TABLE public.questions;
DROP TABLE public.migration;
DROP TYPE public.sex;
--
-- Name: sex; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE public.sex AS ENUM (
    'male',
    'famale'
);


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: migration; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


--
-- Name: questions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.questions (
    id integer NOT NULL,
    date date DEFAULT CURRENT_DATE,
    name character varying(75) NOT NULL,
    email character varying(75) NOT NULL,
    phone character varying(11) NOT NULL,
    region character varying(75) NOT NULL,
    city character varying(75) NOT NULL,
    sex public.sex NOT NULL,
    comment character varying(255) NOT NULL,
    rate integer NOT NULL
);


--
-- Name: COLUMN questions.date; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.date IS 'дата опроса';


--
-- Name: COLUMN questions.name; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.name IS 'имя';


--
-- Name: COLUMN questions.email; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.email IS 'email';


--
-- Name: COLUMN questions.phone; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.phone IS 'телефон';


--
-- Name: COLUMN questions.region; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.region IS 'регион';


--
-- Name: COLUMN questions.city; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.city IS 'город';


--
-- Name: COLUMN questions.comment; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.comment IS 'комментарий';


--
-- Name: COLUMN questions.rate; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.questions.rate IS 'оценка';


--
-- Name: questions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.questions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.questions_id_seq OWNED BY public.questions.id;


--
-- Name: questions id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions ALTER COLUMN id SET DEFAULT nextval('public.questions_id_seq'::regclass);


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1681308349
m230415_080721_create_questions_table	1681565458
\.


--
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.questions (id, date, name, email, phone, region, city, sex, comment, rate) FROM stdin;
1	2023-04-15	qeqwe	wqeqeq@5543f.fd	72242343243	wewq	423432	male	234	6
2	2023-04-15	423432	werewr@ere.43	73223442234	534534543	werewr	male	rwwerw	10
3	2023-04-15	234423	werewr@ere.43	73424324334	324243	3242342	famale	4234323	5
4	2023-04-15	24324	342432@dre.ri	73243243224	43244	43243242	male	ewrwrwre	8
5	2023-04-15	4353453	534@43.ff	75345343543	534543	erteetet	male	tertter	3
6	2023-04-16	ertre	werewr@ere.43	75533534435	tret	rewr	famale	rewr	5
7	2023-04-16	wrewr	werewr@ere.43	75433533433	rwerw	erwerr	famale	werwerw	3
8	2023-04-16	wrewr	werewr@ere.43	72324224242	werwr	rewr	male	rewr	5
9	2023-04-16	ertre	werewr@ere.43	73443345435	ertrretr	rewr	famale	werewr	6
\.


--
-- Name: questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.questions_id_seq', 9, true);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);


--
-- Name: questions-city-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-city-ind" ON public.questions USING btree (city);


--
-- Name: questions-comment-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-comment-ind" ON public.questions USING btree (comment);


--
-- Name: questions-date-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-date-ind" ON public.questions USING btree (date);


--
-- Name: questions-email-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-email-ind" ON public.questions USING btree (email);


--
-- Name: questions-name-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-name-ind" ON public.questions USING btree (name);


--
-- Name: questions-phone-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-phone-ind" ON public.questions USING btree (phone);


--
-- Name: questions-rate-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-rate-ind" ON public.questions USING btree (rate);


--
-- Name: questions-region-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-region-ind" ON public.questions USING btree (region);


--
-- Name: questions-sex-ind; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "questions-sex-ind" ON public.questions USING btree (sex);


--
-- PostgreSQL database dump complete
--

