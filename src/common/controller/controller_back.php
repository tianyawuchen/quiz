<?php
/**
 * @file controller
 * @desc 进行model与view的配置以及分发路由
 *
 * @author wangqi
 * @version 2013.3.2
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class QuizController extends JController {
	private $curModel = "";

	public function display() {
		/* 进行登录状态判定 */
		if(QuizUtil::checkUserPower()) {

			/* model指定 */ 
			$this->setModel('QuizBack');
			
			/* 指定路由分发的view */
			$viewParam = JRequest::getVar('view');
			$this->setView($viewParam);

			/* 执行 */
			$this->displayFunc();
		} else {

		}
	}

	/**
	 * 路由分发到对应的view
	 * 
	 * @param $name {String} view的后缀名
	 *
	 */
	private function setView($name) {
		if($name) {
			$input = JFactory::getApplication()->input;
	  		$input->set('view', $input->getCmd('view', $name));
		}
	}

	/**
	 * 设置对应model
	 *
	 * @param $name {String} model的后缀名
	 *
	 */
	private function setModel($name) {
		$this->curModel = $name;
	}

	/**
	 * 重写controller的执行方法，可进行model的自定义
	 *
	 */
	private function displayFunc() {
		/* 获取所需实例 */
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');

		/* 根据Joomla命名规则获取ui */
		$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath, 'layout' => $viewLayout));

		/* 获取model，并将其与view绑定，若不存在则创建之 */
		if ($model = $this->getModel($this->curModel)) {
			$view->setModel($model, true);
		}

		/* 将doc映射到view中 */
		$view->assignRef('document', $document);

		$conf = JFactory::getConfig();

		/* view执行展示，若命中cache则从cache中执行，否则执行view */		
		if ($cachable && $viewType != 'feed' && $conf->get('caching') >= 1) {
			$option = JRequest::getCmd('option');
			$cache = JFactory::getCache($option, 'view');

			if (is_array($urlparams)) {
				$app = JFactory::getApplication();

				if (!empty($app->registeredurlparams)) {
					$registeredurlparams = $app->registeredurlparams;
				} else {
					$registeredurlparams = new stdClass;
				}

				foreach ($urlparams as $key => $value) {
					$registeredurlparams->$key = $value;
				}

				$app->registeredurlparams = $registeredurlparams;
			}

			$cache->get($view, 'display');
		} else {
			$view->display();
		}

		return $this;
	}

}