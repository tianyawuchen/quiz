<?php
/**
 * @package models/quiz.php
 * @desc 提供统一的model，对BLL层只暴露统一接口，以便调用
 * @class QuizModelQuiz
 *
 * @author wangqi
 * @version 2013-03-06
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

/**
 *	Unit = array(
 *		unit_id	=> 0
 *		title 	=> ""
 *	)
 */

/**
 *	Question = array(
 *		q_id 	 => 0
 *		question => ""
 *		unit_id	 => 0
 *		created  => 0
 *		modified => 0
 *	)
 */

/**
 *	Answer = array(
 *		a_id 	=> 0
 *		answer 	=> ""
 *		q_id 	=> 0
 *		is_right=> 0
 *		created => 0
 *		modified=> 0
 *	)
 */

/**
 * 	QA = array(
 *		qid 	=> 0
 *		question=> ""
 * 		answer 	=> array(
 *			array(
 *				aid    => 0
 *				answer => ""
 *			),
 *			array(
 *				aid    => 0
 *				answer => ""
 *			),
 *		)
 *		right 	=> 0
 *	)
 */

class QuizModelQuizBack extends JModelItem {
	/* 单元部分 */
	/**
	 * @func getUnitList
	 * @desc 获取所有单元列表
	 * @return {Array=>Unit}
	 */
	public function getUnitList() {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_unit';
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
	public function getUnitById($unit_id) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_unit WHERE unit_id='.$unit_id;
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result[0];
	}
	public function addUnit($unit_title, $unit_desc = null) {
		$db = &JFactory::getDBO();
		$query = 'INSERT INTO `#__quiz_unit` (`title`,`desc`) VALUES (\''.$unit_title.'\',\''.$unit_desc.'\')';
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}
	public function deleteUnitById($unit_id) {
		$db = &JFactory::getDBO();
		$query = 'DELETE FROM #__quiz_unit WHERE unit_id='.$unit_id;
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}
	public function updateUnitById($unit_id, $unit_title, $unit_desc = null) {
		$db = &JFactory::getDBO();
		$query = "UPDATE `#__quiz_unit` SET `title`='".$unit_title."', `desc`='".$unit_desc."' WHERE `unit_id`=".$unit_id;
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	/* 题目部分（QUESTION） */
	/**
	 * @func getQuestionList
	 * @desc 获取所有题目列表
	 * @return {Array=>Question}
	 */
	public function getQuestionList() {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_question'; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result;
	}

	/**
	 * @func getQuestionListByUnit
	 * @desc 根据单元id获取题目列表
	 * @param $unitId {int} 单元id
	 * @return {Array=>Question}
	 */
	public function getQuestionByUnit($unit_id) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_question WHERE unit_id='.$unit_id;
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}

	/**
	 * @func getQuestionById
	 * @desc 根据题目id获取题目
	 * @param  $qid {int} 题目id
	 * @return {Question}
	 */
	public function getQuestionById($qid) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_question WHERE q_id='.$qid; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result[0];
	}

	public function deleteQuestionById($qid) {
		$db = &JFactory::getDBO();
		$query = 'DELETE FROM #__quiz_question WHERE q_id='.$qid;
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}
	public function deleteAnswerById($aid) {
		$db = &JFactory::getDBO();
		$query = 'DELETE FROM #__quiz_answer WHERE a_id='.$aid;
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}
	public function deleteAnswerByQid($qid) {
		$db = &JFactory::getDBO();
		$query = 'DELETE FROM #__quiz_answer WHERE q_id='.$qid;
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	public function addQuestion($question, $unit_id = null) {
		$db = &JFactory::getDBO();
		$time = time();
		$query = 'INSERT INTO `#__quiz_question` (`question`,`unit_id`,`created`,`modified`) 
				  VALUES (\''.$question.'\',\''.$unit_id.'\',\''.$time.'\',\''.$time.'\')';
		$db->setQuery($query);
		try {
			$result = $db->query();
			if($result) {
				$id = $db->insertid();
			}
			return $id;
		} catch (Exception $e) {
			return 0;
		}
	}

	public function addAnswer($answer, $q_id, $is_right) {
		$db = &JFactory::getDBO();
		$time = time();
		$query = 'INSERT INTO `#__quiz_answer` (`answer`,`q_id`,`is_right`,`created`,`modified`) 
				  VALUES (\''.$answer.'\',\''.$q_id.'\',\''.$is_right.'\',\''.$time.'\',\''.$time.'\')';
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	public function updateQuestionById($qid, $question, $unit_id) {
		$db = &JFactory::getDBO();
		$time = time();
		$query = "UPDATE `#__quiz_question` 
				  SET `question`='".$question."', `modified`='".$time."', `unit_id`='".$unit_id."' 
				  WHERE `q_id`='".$qid."'";
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	public function updateAnswerById($aid, $answer, $is_right) {
		$db = &JFactory::getDBO();
		$time = time();
		$query = "UPDATE `#__quiz_answer` 
		          SET `answer`='".$answer."', `is_right`='".$is_right."', `modified`='".$time."' 
				  WHERE `a_id`='".$aid."';";
		$db->setQuery($query);
		try {
			$result = $db->query();
			return $result;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * @func getRandQuestionListByNum
	 * @desc 根据Num随机获取Num条数的题目纪录
	 * @param $num {int} 获取题目条数上线
	 * @return {Array=>Question}
	 */
	public function getRandQuestionListByNum($num) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_question ORDER BY RAND() LIMIT '.$num; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result;
	}

	/**
	 * @func getRandQuestionListByNumUnit
	 * @desc 根据Num以及unitId随机获取Num条数的题目纪录
	 * @param $num {int} 获取题目条数上线
	 * @param $unitId {int} 获取题目对应单元id
	 * @return {Array=>Question}
	 */
	public function getRandQuestionListByNumUnit($num, $unitId) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_question WHERE unit_id='.$unitId.' ORDER BY RAND() LIMIT '.$num; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result;
	}

	/* 答案部分(ANSWER) */
	/**
	 * @func getAnswerList
	 * @desc 获取所有答案列表
	 * @return {Array=>Answer}
	 */
	public function getAnswerList() {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_answer'; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result;
	}

	/**
	 * @func getAnswerById
	 * @desc 根据答案id获取答案
	 * @param $aid {int} 答案id
	 * @return {Answer}
	 */
	public function getAnswerById($aid) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_answer WHERE a_id='.$aid; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result[0];
	}

	/**
	 * @func getAnswerListByQid
	 * @desc 根据题目id获取对应答案列表
	 * @param $qid {int} 题目id
	 * @return {Array=>Answer}
	 */
	public function getAnswerListByQid($qid) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_answer WHERE q_id='.$qid; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result;
	}

	/**
	 * @func getRightAnswerListByQid
	 * @desc 根据题目id获取对应正确答案
	 * @param $qid {int} 题目id
	 * @return {Array=>Answer}
	 */
	public function getRightAnswerListByQid($qid) {
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__quiz_answer WHERE is_right=1 AND q_id='.$qid; 
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		return $result[0];
	}

	/* 题目答案组装 */
	/**
	 * @func getQAListByNum
	 * @desc 根据题目数量随机获得
	 * @param $num {int} 题目上限数量
	 * @return {Array=>QA}
	 */
	public function getQAListByNum($num, $unitId = 0) {
		if($unitId == 0 || $unitId == NULL) {
			$qList = $this->getRandQuestionListByNum($num);
		} else {
			$qList = $this->getRandQuestionListByNumUnit($num, $unitId);
		}
		$qaList = array();

		/* 若无结果，则不再执行下方处理，直接返回 */
		if(count($qList) == 0) {
			return $qaList;
		}

		foreach ($qList as $qkey => $qvalue) {
			$qa = array();
			$qa['qid'] = $qvalue->q_id;
			$qa['question'] = $qvalue->question;
			$qa['answer'] = array();

			$aList = $this->getAnswerListByQid($qvalue->q_id);
			foreach ($aList as $akey => $avalue) {
				array_push($qa['answer'], array(
					'aid' => $avalue->a_id,
					'answer' => $avalue->answer
					)
				);
				if($avalue->is_right) {
					$qa['right_aid'] = $avalue->a_id; 
				}
			}
			array_push($qaList, $qa);
		}
		return $qaList;
	}

	/**
	 * @func checkQA
	 * @desc 检测当前答案是否正确
	 * @param $aid {int} 答案id
	 * @return {boolean} 正确 OR 错误
	 */
	public function checkQA($aid) {
		$answer = $this->getAnswerById($aid);
		return $answer->is_right;
	}

}