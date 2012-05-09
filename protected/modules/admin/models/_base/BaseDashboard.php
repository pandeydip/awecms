<?php

/**
 * This is the model base class for the table "dashboard".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Dashboard".
 *
 * Columns in table "dashboard" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $category
 * @property string $name
 * @property string $path
 * @property integer $enabled
 *
 */
abstract class BaseDashboard extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'dashboard';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Dashboard|Dashboards', $n);
	}

	public static function representingColumn() {
		return 'category';
	}

	public function rules() {
		return array(
			array('category, name, path, enabled', 'required'),
			array('enabled', 'numerical', 'integerOnly'=>true),
			array('category, name', 'length', 'max'=>50),
			array('path', 'length', 'max'=>100),
			array('id, category, name, path, enabled', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'category' => Yii::t('app', 'Category'),
			'name' => Yii::t('app', 'Name'),
			'path' => Yii::t('app', 'Path'),
			'enabled' => Yii::t('app', 'Enabled'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('category', $this->category, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('path', $this->path, true);
		$criteria->compare('enabled', $this->enabled);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}