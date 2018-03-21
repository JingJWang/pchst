<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    /**
     * 获取某一篇文章的信息
     */
    function getNotice($nid){
        exit;
        $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link === true) {
            $text = $this->cache->_redis->get('noticeTexts'.$nid);
            if ($text!==false&&!empty($text)) {
                return json_decode($text,true);
            }
        }
        $sql = 'select notice_id as id,notice_title as title,notice_fid as fid,notice_text as text,
                notice_icon as icon from h_company_notice where notice_id='.$nid.' and (notice_status=1 or notice_status=2)';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        if ($this->cache->link === true) {
            $texts = $this->cache->_redis->set('noticeTexts'.$nid,json_encode($result->result_array()));
        }
        return $result->result_array();
    }
    /**
     * 获取页脚全部文章信息
     */
    function getAllNotice(){
        /* $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link === true) {
            $texts = $this->cache->_redis->get('noticeTexts');
            if ($texts!==false&&!empty($texts)) {
                return json_decode($texts,true);
            }
        } */
        $sql = 'select notice_id as id,notice_title as title,notice_fid as fid,notice_icon as icon
                from h_company_notice where notice_type=0 and (notice_status=1 or notice_status=2)';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        $result = $result->result_array();
       /*  foreach ($result as $k => $v) {//组合子集和父集关系
            if ($v['fid']!=0) {
                foreach ($result as $ke => $va) {
                    if ($v['fid'] == $va['id']) {
                        $result[$ke]['son'][]=$v;
                        unset($result[$k]);
                        break;
                    }
                }
            }
        }
        if ($this->cache->link === true) {
            $texts = $this->cache->_redis->set('noticeTexts',json_encode($result));
        } */
        return $result;
    }
    /**
     * 获取某个父类为此值的信息
     * @param       int      fid      父id
     * @return      成功返回array|错误返回false
     */
    function getTypeNotice($fid){
        $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link === true) {
            $tTexts = $this->cache->_redis->get('typeNotice_'.$fid);
            if ($tTexts!==false&&!empty($tTexts)) {
                return json_decode($tTexts,true);
            }
        }
        $sql = 'select notice_id as id,notice_title as title,notice_fid as fid,notice_text as text,
                notice_icon as icon from h_company_notice where (notice_fid='.$fid.' or notice_id='.$fid.') 
                and (notice_status=1 or notice_status=2)';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        $result = $result->result_array();
        if ($this->cache->link === true) {
            $tTexts = $this->cache->_redis->set('typeNotice_'.$fid,json_encode($result));
        }
        return $result;
    }
    /**
     * 获取某个类型的文章
     * @param       int      type      文章类型
     * @return      成功返回array|错误返回false
     */
    function oneTypeText($type){
        $this->load->library('common/cache',$this->config->item('redis_config_aliyun'));//redis加载
        $this->cache->getRedis($this->config->item('redis_config_aliyun'));
        if ($this->cache->link === true) {
            $texts = $this->cache->_redis->get('noticeTexts_'.$type);
            if ($texts!==false&&!empty($texts)) {
                return json_decode($texts,true);
            }
        }
        $sql = 'select notice_id as id,notice_title as title,notice_des as des,notice_icon as img,notice_fid as fid,notice_icon as icon,
                notice_jointime as jtime from h_company_notice where notice_fid='.$type.' and notice_type=1 and 
                (notice_status=1 or notice_status=2) order by notice_jointime desc';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        if ($this->cache->link === true) {
            $texts = $this->cache->_redis->set('noticeTexts_'.$type,json_encode($result->result_array()));
        }
        return $result->result_array();
    }
    /**
     * 获取文章的所有类型
     */
    function getArticleType(){
        $sql = 'select notice_id as id,notice_title as title from h_company_notice where notice_fid=0 and notice_type=1';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 获取某篇文章
     * @param       int      tid      文章的id
     * @return      成功返回array|错误返回false
     */
    function getAText($tid){
        $sql = 'select notice_id as id,notice_title as title,notice_des as des,notice_icon as img,notice_fid as fid,notice_icon as icon,
                notice_keys as nkey,notice_jointime as jtime,notice_text as text,notice_fid as type from h_company_notice where 
                notice_id='.$tid.' and (notice_status=1 or notice_status=2) and notice_type=1';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    /**
     * 获取最新的资讯
     */
    function hotInfomation(){
        $sql = 'select notice_id as id,notice_title as title,notice_des as content from h_company_notice where notice_type=1 and 
                notice_fid!=0 and notice_status!=-1 order by notice_id desc limit 4';
        $result = $this->db->query($sql);
        if ($result->num_rows<1) {
            return false;
        }
        return $result->result_array();
    }
    function __destruct(){
        $this->db->close();
    }
}