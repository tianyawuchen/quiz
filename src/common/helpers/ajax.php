<?php
defined('_JEXEC') or die('Restricted access');

class QuizAjax{
	private $data = null;
	private $code = null;
	private $msg = null;

	public function __construct($data = null, $code = 0, $msg = 'success') {
		$this->data = $data;
		$this->code = $code;
		$this->msg = $msg;
	}

	public static function formatAjax($data, $code = 0, $msg = 'success') {
		$output = array(
			'status' => array(
				'code' => $code,
				'msg' => $msg
				),
			'data' => $data
			);
		return $output;
	}

	public function display() {
		$document = JFactory::getDocument();

		/* 设置mime-type */
		$document->setMimeEncoding('application/json');

		/* Change the suggested filename */
		JResponse::setHeader('Content-Disposition','attachment;filename="'.'ajax'.'.json"');
		 
		/* json输出 */
		echo json_encode(self::formatAjax($this->data, $this->code, $this->msg));

		/* 不执行页面渲染 */
		jexit();
	}
}