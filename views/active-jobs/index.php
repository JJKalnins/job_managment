<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Active Job List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active_job-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <a href="<?= Url::to(['active-jobs/update']) ?>" id="link_to_save_data" class="d-none"></a>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $employees,
            'key' => 'id',
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            'id',
            [
                'label' => "Name",
                'value' => function ($model) {
                    return $model->name . " " . $model->lastname; // Access the custom attribute
                },
            ],
            [
                'attribute' => "active-jobs",
                'label' => "Assign Jobs",
                'format' => 'raw', // To render HTML
                'value' => function ($model) use ($job_data, $construction_site_names, $work_items) {
                    // Define the dropdown list
                    $dropdownList = Html::dropDownList(
                        'custom-attribute-dropdown', // Dropdown name
                        null, // Selected value (null for now)
                        ["-- Select --", ...$model->sites],
                        [
                            'class' => 'form-control', // CSS class for styling
                        ]
                    );

                    $html = "<button class=\"addLocation btn btn-primary btn-sm\" person_id='" . $model->id . "'>Add</button>";

                    $main_job_html = "";
                    if (!empty($job_data) && isset($job_data[$model->id])) {

                        foreach ($job_data[$model->id] as $company_id => $job_ids) {
                            $drop_identity = $model->id . '_' . $company_id . "_";

                            $job_html = '
                                
                                <div class="specific_location">
                                    <div class="location_name">
                                        <span>' . $construction_site_names[$company_id] . '</span> 
                                    </div> 
                                    <div ondrop="drop(event,\'' . $drop_identity . '\')" ondragover="allowDrop(event)" job_status="unassigned" class="job_assign">  
                                        {{ unassigned_tasks }}
                                    </div> 
                                    <div ondrop="drop(event,\'' . $drop_identity . '\')" ondragover="allowDrop(event)" job_status="assigned" class="job_assign">
                                        {{ assigned_tasks }}
                                    </div>
                                </div>
                                ';
                            $assigned_tasks = "";
                            $unassigned_tasks = "";

                            foreach ($work_items as $work_item) {
                                $unique_id = "job_" . $work_item['id'] . "_" . $drop_identity;
                                $job_template = '<span id="' . $unique_id . '" from="' . $drop_identity . '" draggable="true" ondragstart="drag(event)">' . $work_item['name'] . '</span>';

                                if (array_key_exists($work_item['id'], $job_ids)) {
                                    $assigned_tasks .= $job_template;
                                } else {
                                    $unassigned_tasks .= $job_template;
                                }
                            }

                            $job_html = str_replace("{{ unassigned_tasks }}", $unassigned_tasks, $job_html);
                            $job_html = str_replace("{{ assigned_tasks }}", $assigned_tasks, $job_html);

                            $main_job_html .= $job_html;
                        }
                    }

                    return "<div class='d-flex '>" . $dropdownList . $html  . "</div>" . $main_job_html;
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
<button id="saveAllInformation" class="btn btn-primary">Save all</button>
<script>
    var work_items = <?= json_encode($work_items) ?>
</script>
<?php

$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::class]]);
