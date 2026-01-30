<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminDashboardContainerComp extends Component
{
    public $currentComponent = 'dashboard';
    public $sidebarOpen = true;
    public $expandedMenus = [];
    
    public $menuItems = [
        [
            'name' => 'Dashboard',
            'component' => 'dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'submenu' => []
        ],
        [
            'name' => 'Users',
            'component' => 'users',
            'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            'submenu' => [
                [
                    'name' => 'All Users',
                    'component' => 'users.all'
                ],
                [
                    'name' => 'Add New User',
                    'component' => 'users.create'
                ],
                [
                    'name' => 'User Roles',
                    'component' => 'users.roles'
                ],
                [
                    'name' => 'Permissions',
                    'component' => 'users.permissions'
                ]
            ]
        ],
        [
            'name' => 'Basic',
            'component' => 'basic',
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            'submenu' => [
                [
                    'name' => 'All Basics',
                    'component' => 'basic.wall'
                ],
                // [
                //     'name' => 'School',
                //     'component' => 'basic.school'
                // ],
                // [
                //     'name' => 'Session',
                //     'component' => 'basic.session'
                // ],
                // [
                //     'name' => 'Class',
                //     'component' => 'basic.class'
                // ],
                // [
                //     'name' => 'Section',
                //     'component' => 'basic.section'
                // ],
                // [
                //     'name' => 'Subject',
                //     'component' => 'basic.subject'
                // ],                
                // [
                //     'name' => 'Room',
                //     'component' => 'basic.room'
                // ],
                [
                    'name' => 'Teacher',
                    'component' => 'basic.teacher'
                ],
                [
                    'name' => 'Class-Section',
                    'component' => 'basic.class_section'
                ],
                [
                    'name' => 'Class-Subject',
                    'component' => 'basic.class_subject'
                ]
            ]
        ],
        [
            'name' => 'Exam Settings',
            'component' => 'exam_settings',
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            'submenu' => [
                [
                    'name' => 'Exam Details',
                    'component' => 'exam.detail'
                ],
                [
                    'name' => 'Exam FMPM',
                    'component' => 'exam.fmpm'
                ],
                [
                    'name' => 'Exam Name',
                    'component' => 'exam.exam_name'
                ],
                [
                    'name' => 'Exam Type',
                    'component' => 'exam.exam_type'
                ],
                [
                    'name' => 'Exam Parts',
                    'component' => 'exam.exam_part'
                ],
                
                [
                    'name' => 'Exam Mode',
                    'component' => 'exam.exam_mode'
                ],
                [
                    'name' => 'Exam Class-Subject',
                    'component' => 'exam.exam_class_subject'
                ],
                [
                    'name' => 'Exam Schedule',
                    'component' => 'exam.exam_schedule'
                ],
            ]
        ],
        [
            'name' => 'Marks Entry',
            'component' => 'marks_entry',
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
            'submenu' => [
                [
                    'name' => 'Marks Entry wall',
                    'component' => 'marks_entry.wall'
                ],
                [
                    'name' => 'An Scr Detail',
                    'component' => 'marks_entry.anscr_distribution'
                ],
                [
                    'name' => 'Marks Entry',
                    'component' => 'marks_entry.marks_entry'
                ],
                [
                    'name' => 'Mark Register',
                    'component' => 'marks_entry.mark_register'
                ],                
                [
                    'name' => 'Teacher Entry',
                    'component' => 'exam.teacher_marks_entry'
                ],
                [
                    'name' => 'Mark Sheet',
                    'component' => 'exam.student_mark_sheet'
                ],
            ]
        ],
        [
            'name' => 'Orders',
            'component' => 'orders',
            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'submenu' => [
                [
                    'name' => 'All Orders',
                    'component' => 'orders.all'
                ],
                [
                    'name' => 'Pending Orders',
                    'component' => 'orders.pending'
                ],
                [
                    'name' => 'Completed',
                    'component' => 'orders.completed'
                ],
                [
                    'name' => 'Cancelled',
                    'component' => 'orders.cancelled'
                ]
            ]
        ],
        [
            'name' => 'Reports',
            'component' => 'reports',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'submenu' => [
                [
                    'name' => 'Sales Report',
                    'component' => 'reports.sales'
                ],
                [
                    'name' => 'Analytics',
                    'component' => 'reports.analytics'
                ],
                [
                    'name' => 'Customer Report',
                    'component' => 'reports.customers'
                ]
            ]
        ],
        [
            'name' => 'Settings',
            'component' => 'settings',
            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
            'submenu' => [
                [
                    'name' => 'General',
                    'component' => 'settings.general'
                ],
                [
                    'name' => 'Security',
                    'component' => 'settings.security'
                ],
                [
                    'name' => 'Email Templates',
                    'component' => 'settings.email'
                ]
            ]
        ],
    ];

    public function mount()
    {
        $this->currentComponent = 'dashboard';
        $this->expandedMenus = [];
    }

    public function switchComponent($component)
    {
        $this->currentComponent = $component;
    }

    public function toggleMenu($index)
    {
        if (in_array($index, $this->expandedMenus)) {
            $this->expandedMenus = array_diff($this->expandedMenus, [$index]);
        } else {
            $this->expandedMenus[] = $index;
        }
    }

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
        // Collapse all menus when sidebar is closed
        if (!$this->sidebarOpen) {
            $this->expandedMenus = [];
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard-container-comp');
    }
}
