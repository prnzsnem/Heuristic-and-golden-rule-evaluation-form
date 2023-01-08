<?php

// Global variable for table object
$evaluationdata = NULL;

//
// Table class for evaluationdata
//
class crevaluationdata extends crTableBase {
	var $ID;
	var $title;
	var $url;
	var $user;
	var $qa;
	var $ra;
	var $ma;
	var $qb;
	var $rb;
	var $mb;
	var $qc;
	var $rc;
	var $mc;
	var $qd;
	var $rd;
	var $md;
	var $qe;
	var $re;
	var $me;
	var $qf;
	var $rf;
	var $mf;
	var $qg;
	var $rg;
	var $mg;
	var $qh;
	var $rh;
	var $mh;
	var $qi;
	var $ri;
	var $mi;
	var $qj;
	var $rj;
	var $mj;
	var $qk;
	var $rk;
	var $mk;
	var $ql;
	var $rl;
	var $ml;
	var $qm;
	var $rm;
	var $mm;
	var $qn;
	var $rn;
	var $mn;
	var $qo;
	var $ro;
	var $mo;
	var $qp;
	var $rp;
	var $mp;
	var $qq;
	var $rq;
	var $mq;
	var $qr;
	var $rr;
	var $mr;
	var $qs;
	var $_rs;
	var $ms;
	var $qt;
	var $rt;
	var $mt;
	var $messg;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'evaluationdata';
		$this->TableName = 'evaluationdata';
		$this->TableType = 'TABLE';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// ID
		$this->ID = new crField('evaluationdata', 'evaluationdata', 'x_ID', 'ID', '`ID`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;
		$this->ID->DateFilter = "";
		$this->ID->SqlSelect = "";
		$this->ID->SqlOrderBy = "";

		// title
		$this->title = new crField('evaluationdata', 'evaluationdata', 'x_title', 'title', '`title`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['title'] = &$this->title;
		$this->title->DateFilter = "";
		$this->title->SqlSelect = "";
		$this->title->SqlOrderBy = "";

		// url
		$this->url = new crField('evaluationdata', 'evaluationdata', 'x_url', 'url', '`url`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['url'] = &$this->url;
		$this->url->DateFilter = "";
		$this->url->SqlSelect = "";
		$this->url->SqlOrderBy = "";

		// user
		$this->user = new crField('evaluationdata', 'evaluationdata', 'x_user', 'user', '`user`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['user'] = &$this->user;
		$this->user->DateFilter = "";
		$this->user->SqlSelect = "";
		$this->user->SqlOrderBy = "";

		// qa
		$this->qa = new crField('evaluationdata', 'evaluationdata', 'x_qa', 'qa', '`qa`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qa'] = &$this->qa;
		$this->qa->DateFilter = "";
		$this->qa->SqlSelect = "";
		$this->qa->SqlOrderBy = "";

		// ra
		$this->ra = new crField('evaluationdata', 'evaluationdata', 'x_ra', 'ra', '`ra`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ra->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ra'] = &$this->ra;
		$this->ra->DateFilter = "";
		$this->ra->SqlSelect = "";
		$this->ra->SqlOrderBy = "";

		// ma
		$this->ma = new crField('evaluationdata', 'evaluationdata', 'x_ma', 'ma', '`ma`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['ma'] = &$this->ma;
		$this->ma->DateFilter = "";
		$this->ma->SqlSelect = "";
		$this->ma->SqlOrderBy = "";

		// qb
		$this->qb = new crField('evaluationdata', 'evaluationdata', 'x_qb', 'qb', '`qb`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qb'] = &$this->qb;
		$this->qb->DateFilter = "";
		$this->qb->SqlSelect = "";
		$this->qb->SqlOrderBy = "";

		// rb
		$this->rb = new crField('evaluationdata', 'evaluationdata', 'x_rb', 'rb', '`rb`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rb->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rb'] = &$this->rb;
		$this->rb->DateFilter = "";
		$this->rb->SqlSelect = "";
		$this->rb->SqlOrderBy = "";

		// mb
		$this->mb = new crField('evaluationdata', 'evaluationdata', 'x_mb', 'mb', '`mb`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mb'] = &$this->mb;
		$this->mb->DateFilter = "";
		$this->mb->SqlSelect = "";
		$this->mb->SqlOrderBy = "";

		// qc
		$this->qc = new crField('evaluationdata', 'evaluationdata', 'x_qc', 'qc', '`qc`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qc'] = &$this->qc;
		$this->qc->DateFilter = "";
		$this->qc->SqlSelect = "";
		$this->qc->SqlOrderBy = "";

		// rc
		$this->rc = new crField('evaluationdata', 'evaluationdata', 'x_rc', 'rc', '`rc`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rc->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rc'] = &$this->rc;
		$this->rc->DateFilter = "";
		$this->rc->SqlSelect = "";
		$this->rc->SqlOrderBy = "";

		// mc
		$this->mc = new crField('evaluationdata', 'evaluationdata', 'x_mc', 'mc', '`mc`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->mc->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['mc'] = &$this->mc;
		$this->mc->DateFilter = "";
		$this->mc->SqlSelect = "";
		$this->mc->SqlOrderBy = "";

		// qd
		$this->qd = new crField('evaluationdata', 'evaluationdata', 'x_qd', 'qd', '`qd`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qd'] = &$this->qd;
		$this->qd->DateFilter = "";
		$this->qd->SqlSelect = "";
		$this->qd->SqlOrderBy = "";

		// rd
		$this->rd = new crField('evaluationdata', 'evaluationdata', 'x_rd', 'rd', '`rd`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rd->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rd'] = &$this->rd;
		$this->rd->DateFilter = "";
		$this->rd->SqlSelect = "";
		$this->rd->SqlOrderBy = "";

		// md
		$this->md = new crField('evaluationdata', 'evaluationdata', 'x_md', 'md', '`md`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->md->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['md'] = &$this->md;
		$this->md->DateFilter = "";
		$this->md->SqlSelect = "";
		$this->md->SqlOrderBy = "";

		// qe
		$this->qe = new crField('evaluationdata', 'evaluationdata', 'x_qe', 'qe', '`qe`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qe'] = &$this->qe;
		$this->qe->DateFilter = "";
		$this->qe->SqlSelect = "";
		$this->qe->SqlOrderBy = "";

		// re
		$this->re = new crField('evaluationdata', 'evaluationdata', 'x_re', 're', '`re`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->re->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['re'] = &$this->re;
		$this->re->DateFilter = "";
		$this->re->SqlSelect = "";
		$this->re->SqlOrderBy = "";

		// me
		$this->me = new crField('evaluationdata', 'evaluationdata', 'x_me', 'me', '`me`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['me'] = &$this->me;
		$this->me->DateFilter = "";
		$this->me->SqlSelect = "";
		$this->me->SqlOrderBy = "";

		// qf
		$this->qf = new crField('evaluationdata', 'evaluationdata', 'x_qf', 'qf', '`qf`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qf'] = &$this->qf;
		$this->qf->DateFilter = "";
		$this->qf->SqlSelect = "";
		$this->qf->SqlOrderBy = "";

		// rf
		$this->rf = new crField('evaluationdata', 'evaluationdata', 'x_rf', 'rf', '`rf`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rf->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rf'] = &$this->rf;
		$this->rf->DateFilter = "";
		$this->rf->SqlSelect = "";
		$this->rf->SqlOrderBy = "";

		// mf
		$this->mf = new crField('evaluationdata', 'evaluationdata', 'x_mf', 'mf', '`mf`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mf'] = &$this->mf;
		$this->mf->DateFilter = "";
		$this->mf->SqlSelect = "";
		$this->mf->SqlOrderBy = "";

		// qg
		$this->qg = new crField('evaluationdata', 'evaluationdata', 'x_qg', 'qg', '`qg`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qg'] = &$this->qg;
		$this->qg->DateFilter = "";
		$this->qg->SqlSelect = "";
		$this->qg->SqlOrderBy = "";

		// rg
		$this->rg = new crField('evaluationdata', 'evaluationdata', 'x_rg', 'rg', '`rg`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rg->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rg'] = &$this->rg;
		$this->rg->DateFilter = "";
		$this->rg->SqlSelect = "";
		$this->rg->SqlOrderBy = "";

		// mg
		$this->mg = new crField('evaluationdata', 'evaluationdata', 'x_mg', 'mg', '`mg`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mg'] = &$this->mg;
		$this->mg->DateFilter = "";
		$this->mg->SqlSelect = "";
		$this->mg->SqlOrderBy = "";

		// qh
		$this->qh = new crField('evaluationdata', 'evaluationdata', 'x_qh', 'qh', '`qh`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qh'] = &$this->qh;
		$this->qh->DateFilter = "";
		$this->qh->SqlSelect = "";
		$this->qh->SqlOrderBy = "";

		// rh
		$this->rh = new crField('evaluationdata', 'evaluationdata', 'x_rh', 'rh', '`rh`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rh->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rh'] = &$this->rh;
		$this->rh->DateFilter = "";
		$this->rh->SqlSelect = "";
		$this->rh->SqlOrderBy = "";

		// mh
		$this->mh = new crField('evaluationdata', 'evaluationdata', 'x_mh', 'mh', '`mh`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mh'] = &$this->mh;
		$this->mh->DateFilter = "";
		$this->mh->SqlSelect = "";
		$this->mh->SqlOrderBy = "";

		// qi
		$this->qi = new crField('evaluationdata', 'evaluationdata', 'x_qi', 'qi', '`qi`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qi'] = &$this->qi;
		$this->qi->DateFilter = "";
		$this->qi->SqlSelect = "";
		$this->qi->SqlOrderBy = "";

		// ri
		$this->ri = new crField('evaluationdata', 'evaluationdata', 'x_ri', 'ri', '`ri`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ri->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ri'] = &$this->ri;
		$this->ri->DateFilter = "";
		$this->ri->SqlSelect = "";
		$this->ri->SqlOrderBy = "";

		// mi
		$this->mi = new crField('evaluationdata', 'evaluationdata', 'x_mi', 'mi', '`mi`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mi'] = &$this->mi;
		$this->mi->DateFilter = "";
		$this->mi->SqlSelect = "";
		$this->mi->SqlOrderBy = "";

		// qj
		$this->qj = new crField('evaluationdata', 'evaluationdata', 'x_qj', 'qj', '`qj`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qj'] = &$this->qj;
		$this->qj->DateFilter = "";
		$this->qj->SqlSelect = "";
		$this->qj->SqlOrderBy = "";

		// rj
		$this->rj = new crField('evaluationdata', 'evaluationdata', 'x_rj', 'rj', '`rj`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rj->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rj'] = &$this->rj;
		$this->rj->DateFilter = "";
		$this->rj->SqlSelect = "";
		$this->rj->SqlOrderBy = "";

		// mj
		$this->mj = new crField('evaluationdata', 'evaluationdata', 'x_mj', 'mj', '`mj`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->mj->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['mj'] = &$this->mj;
		$this->mj->DateFilter = "";
		$this->mj->SqlSelect = "";
		$this->mj->SqlOrderBy = "";

		// qk
		$this->qk = new crField('evaluationdata', 'evaluationdata', 'x_qk', 'qk', '`qk`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qk'] = &$this->qk;
		$this->qk->DateFilter = "";
		$this->qk->SqlSelect = "";
		$this->qk->SqlOrderBy = "";

		// rk
		$this->rk = new crField('evaluationdata', 'evaluationdata', 'x_rk', 'rk', '`rk`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rk->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rk'] = &$this->rk;
		$this->rk->DateFilter = "";
		$this->rk->SqlSelect = "";
		$this->rk->SqlOrderBy = "";

		// mk
		$this->mk = new crField('evaluationdata', 'evaluationdata', 'x_mk', 'mk', '`mk`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mk'] = &$this->mk;
		$this->mk->DateFilter = "";
		$this->mk->SqlSelect = "";
		$this->mk->SqlOrderBy = "";

		// ql
		$this->ql = new crField('evaluationdata', 'evaluationdata', 'x_ql', 'ql', '`ql`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['ql'] = &$this->ql;
		$this->ql->DateFilter = "";
		$this->ql->SqlSelect = "";
		$this->ql->SqlOrderBy = "";

		// rl
		$this->rl = new crField('evaluationdata', 'evaluationdata', 'x_rl', 'rl', '`rl`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rl->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rl'] = &$this->rl;
		$this->rl->DateFilter = "";
		$this->rl->SqlSelect = "";
		$this->rl->SqlOrderBy = "";

		// ml
		$this->ml = new crField('evaluationdata', 'evaluationdata', 'x_ml', 'ml', '`ml`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['ml'] = &$this->ml;
		$this->ml->DateFilter = "";
		$this->ml->SqlSelect = "";
		$this->ml->SqlOrderBy = "";

		// qm
		$this->qm = new crField('evaluationdata', 'evaluationdata', 'x_qm', 'qm', '`qm`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qm'] = &$this->qm;
		$this->qm->DateFilter = "";
		$this->qm->SqlSelect = "";
		$this->qm->SqlOrderBy = "";

		// rm
		$this->rm = new crField('evaluationdata', 'evaluationdata', 'x_rm', 'rm', '`rm`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rm->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rm'] = &$this->rm;
		$this->rm->DateFilter = "";
		$this->rm->SqlSelect = "";
		$this->rm->SqlOrderBy = "";

		// mm
		$this->mm = new crField('evaluationdata', 'evaluationdata', 'x_mm', 'mm', '`mm`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mm'] = &$this->mm;
		$this->mm->DateFilter = "";
		$this->mm->SqlSelect = "";
		$this->mm->SqlOrderBy = "";

		// qn
		$this->qn = new crField('evaluationdata', 'evaluationdata', 'x_qn', 'qn', '`qn`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qn'] = &$this->qn;
		$this->qn->DateFilter = "";
		$this->qn->SqlSelect = "";
		$this->qn->SqlOrderBy = "";

		// rn
		$this->rn = new crField('evaluationdata', 'evaluationdata', 'x_rn', 'rn', '`rn`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rn->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rn'] = &$this->rn;
		$this->rn->DateFilter = "";
		$this->rn->SqlSelect = "";
		$this->rn->SqlOrderBy = "";

		// mn
		$this->mn = new crField('evaluationdata', 'evaluationdata', 'x_mn', 'mn', '`mn`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mn'] = &$this->mn;
		$this->mn->DateFilter = "";
		$this->mn->SqlSelect = "";
		$this->mn->SqlOrderBy = "";

		// qo
		$this->qo = new crField('evaluationdata', 'evaluationdata', 'x_qo', 'qo', '`qo`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qo'] = &$this->qo;
		$this->qo->DateFilter = "";
		$this->qo->SqlSelect = "";
		$this->qo->SqlOrderBy = "";

		// ro
		$this->ro = new crField('evaluationdata', 'evaluationdata', 'x_ro', 'ro', '`ro`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ro->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ro'] = &$this->ro;
		$this->ro->DateFilter = "";
		$this->ro->SqlSelect = "";
		$this->ro->SqlOrderBy = "";

		// mo
		$this->mo = new crField('evaluationdata', 'evaluationdata', 'x_mo', 'mo', '`mo`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mo'] = &$this->mo;
		$this->mo->DateFilter = "";
		$this->mo->SqlSelect = "";
		$this->mo->SqlOrderBy = "";

		// qp
		$this->qp = new crField('evaluationdata', 'evaluationdata', 'x_qp', 'qp', '`qp`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qp'] = &$this->qp;
		$this->qp->DateFilter = "";
		$this->qp->SqlSelect = "";
		$this->qp->SqlOrderBy = "";

		// rp
		$this->rp = new crField('evaluationdata', 'evaluationdata', 'x_rp', 'rp', '`rp`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rp->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rp'] = &$this->rp;
		$this->rp->DateFilter = "";
		$this->rp->SqlSelect = "";
		$this->rp->SqlOrderBy = "";

		// mp
		$this->mp = new crField('evaluationdata', 'evaluationdata', 'x_mp', 'mp', '`mp`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mp'] = &$this->mp;
		$this->mp->DateFilter = "";
		$this->mp->SqlSelect = "";
		$this->mp->SqlOrderBy = "";

		// qq
		$this->qq = new crField('evaluationdata', 'evaluationdata', 'x_qq', 'qq', '`qq`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qq'] = &$this->qq;
		$this->qq->DateFilter = "";
		$this->qq->SqlSelect = "";
		$this->qq->SqlOrderBy = "";

		// rq
		$this->rq = new crField('evaluationdata', 'evaluationdata', 'x_rq', 'rq', '`rq`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rq->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rq'] = &$this->rq;
		$this->rq->DateFilter = "";
		$this->rq->SqlSelect = "";
		$this->rq->SqlOrderBy = "";

		// mq
		$this->mq = new crField('evaluationdata', 'evaluationdata', 'x_mq', 'mq', '`mq`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mq'] = &$this->mq;
		$this->mq->DateFilter = "";
		$this->mq->SqlSelect = "";
		$this->mq->SqlOrderBy = "";

		// qr
		$this->qr = new crField('evaluationdata', 'evaluationdata', 'x_qr', 'qr', '`qr`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qr'] = &$this->qr;
		$this->qr->DateFilter = "";
		$this->qr->SqlSelect = "";
		$this->qr->SqlOrderBy = "";

		// rr
		$this->rr = new crField('evaluationdata', 'evaluationdata', 'x_rr', 'rr', '`rr`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rr->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rr'] = &$this->rr;
		$this->rr->DateFilter = "";
		$this->rr->SqlSelect = "";
		$this->rr->SqlOrderBy = "";

		// mr
		$this->mr = new crField('evaluationdata', 'evaluationdata', 'x_mr', 'mr', '`mr`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mr'] = &$this->mr;
		$this->mr->DateFilter = "";
		$this->mr->SqlSelect = "";
		$this->mr->SqlOrderBy = "";

		// qs
		$this->qs = new crField('evaluationdata', 'evaluationdata', 'x_qs', 'qs', '`qs`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qs'] = &$this->qs;
		$this->qs->DateFilter = "";
		$this->qs->SqlSelect = "";
		$this->qs->SqlOrderBy = "";

		// rs
		$this->_rs = new crField('evaluationdata', 'evaluationdata', 'x__rs', 'rs', '`rs`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->_rs->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['_rs'] = &$this->_rs;
		$this->_rs->DateFilter = "";
		$this->_rs->SqlSelect = "";
		$this->_rs->SqlOrderBy = "";

		// ms
		$this->ms = new crField('evaluationdata', 'evaluationdata', 'x_ms', 'ms', '`ms`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['ms'] = &$this->ms;
		$this->ms->DateFilter = "";
		$this->ms->SqlSelect = "";
		$this->ms->SqlOrderBy = "";

		// qt
		$this->qt = new crField('evaluationdata', 'evaluationdata', 'x_qt', 'qt', '`qt`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qt'] = &$this->qt;
		$this->qt->DateFilter = "";
		$this->qt->SqlSelect = "";
		$this->qt->SqlOrderBy = "";

		// rt
		$this->rt = new crField('evaluationdata', 'evaluationdata', 'x_rt', 'rt', '`rt`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rt->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rt'] = &$this->rt;
		$this->rt->DateFilter = "";
		$this->rt->SqlSelect = "";
		$this->rt->SqlOrderBy = "";

		// mt
		$this->mt = new crField('evaluationdata', 'evaluationdata', 'x_mt', 'mt', '`mt`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mt'] = &$this->mt;
		$this->mt->DateFilter = "";
		$this->mt->SqlSelect = "";
		$this->mt->SqlOrderBy = "";

		// messg
		$this->messg = new crField('evaluationdata', 'evaluationdata', 'x_messg', 'messg', '`messg`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['messg'] = &$this->messg;
		$this->messg->DateFilter = "";
		$this->messg->SqlSelect = "";
		$this->messg->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`evaluationdata`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here	
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		// if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//     $filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
