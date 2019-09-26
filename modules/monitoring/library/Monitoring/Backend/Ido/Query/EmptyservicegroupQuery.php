<?php
/* Icinga Web 2 | (c) 2019 Icinga GmbH | GPLv2+ */

namespace Icinga\Module\Monitoring\Backend\Ido\Query;

class EmptyservicegroupQuery extends ServicegroupQuery
{
    protected $subQueryTargets = [];

    protected $columnMap = [
        'servicegroups' => [
            'servicegroup'          => 'sgo.name1 COLLATE latin1_general_ci',
            'servicegroup_alias'    => 'sg.alias COLLATE latin1_general_ci',
            'servicegroup_name'     => 'sgo.name1',
            'host_name'             => '(NULL)',
            'hostgroup_name'        => '(NULL)',
            'service_description'   => '(NULL)'
        ],
        'instances' => [
            'instance_name'         => 'i.instance_name'
        ]
    ];

    protected function joinBaseTables()
    {
        parent::joinBaseTables();

        $this->select->joinLeft(
            ['esgm' => $this->prefix . 'servicegroup_members'],
            'esgm.servicegroup_id = sg.servicegroup_id',
            []
        );
        $this->select->group('sgo.object_id');
        $this->select->having('COUNT(esgm.servicegroup_member_id) = ?', 0);
    }
}
