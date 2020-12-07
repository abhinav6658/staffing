<?php

defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items() {
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('dashboard', [
        'name'     => _l('als_dashboard'),
        'href'     => admin_url(),
        'position' => 1,
        'icon'     => 'fa fa-home',
    ]);

    if (has_permission('customers', '', 'view')
        || (have_assigned_customers()
        || (!have_assigned_customers() && has_permission('customers', '', 'create')))) {
        $CI->app_menu->add_sidebar_menu_item('customers', [
            'name'     => _l('Agency'),
            'href'     => admin_url('clients'),
            'position' => 5,
            'icon'     => 'fa fa-building-o',
        ]);
    }
	
    if (has_permission('knowledge_base', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('knowledge-base', [
                'name'     => _l('als_kb'),
                'href'     => admin_url('knowledge_base'),
                'icon'     => 'fa fa-folder-open-o',
                'position' => 50,
        ]);
    }
	/*if (has_permission('Category', '', 'view')
        || (have_assigned_customers()
        || (!have_assigned_customers() && has_permission('Category', '', 'create')))) {
        $CI->app_menu->add_sidebar_menu_item('Category', [
            'name'     => _l('Category'),
            'href'     => admin_url('category'),
            'position' => 56,
            'icon'     => 'fa fa-list-ul',
        ]);
    }
	if (has_permission('Sub-Category', '', 'view')
        || (have_assigned_customers()
        || (!have_assigned_customers() && has_permission('Sub-Category', '', 'create')))) {
        $CI->app_menu->add_sidebar_menu_item('Sub-Category', [
            'name'     => _l('Sub-Category'),
            'href'     => admin_url('sub_category'),
            'position' => 56,
            'icon'     => 'fa fa-list-ul',
        ]);
    }*/
	
    if (has_permission('reports', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('reports', [
                'collapse' => true,
                'name'     => _l('als_reports'),
                'href'     => admin_url('reports'),
                'icon'     => 'fa fa-area-chart',
                'position' => 60,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'sales-reports',
                'name'     => _l('als_reports_sales_submenu'),
                'href'     => admin_url('reports/sales'),
                'position' => 5,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'expenses-reports',
                'name'     => _l('als_reports_expenses'),
                'href'     => admin_url('reports/expenses'),
                'position' => 10,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'expenses-vs-income-reports',
                'name'     => _l('als_expenses_vs_income'),
                'href'     => admin_url('reports/expenses_vs_income'),
                'position' => 15,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'leads-reports',
                'name'     => _l('als_reports_leads_submenu'),
                'href'     => admin_url('reports/leads'),
                'position' => 20,
        ]);

        if (is_admin()) {
            $CI->app_menu->add_sidebar_children_item('reports', [
                    'slug'     => 'timesheets-reports',
                    'name'     => _l('timesheets_overview'),
                    'href'     => admin_url('staff/timesheets?view=all'),
                    'position' => 25,
            ]);
        }

        $CI->app_menu->add_sidebar_children_item('reports', [
                    'slug'     => 'knowledge-base-reports',
                    'name'     => _l('als_kb_articles_submenu'),
                    'href'     => admin_url('reports/knowledge_base_articles'),
                    'position' => 30,
            ]);
    }

    $CI->app_menu->add_sidebar_menu_item('DMAS Activity', [
        'name'     => _l('DMAS Activity'),
        'href'     => admin_url('Common/dmas_activity'),
        'position' => 100,
        'icon'     => 'fa fa-list-ul',
    ]);
    // Setup menu
    if (has_permission('staff', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('staff', [
                    'name'     => _l('als_staff'),
                    'href'     => admin_url('staff'),
                    'position' => 5,
            ]);
    }

    if (is_admin()) {
        $CI->app_menu->add_setup_menu_item('roles', [
            'href'     => admin_url('roles'),
            'name'     => _l('acs_roles'),
            'position' => 55,
        ]);
		if (has_permission('settings', '', 'view')) {
			$CI->app_menu->add_setup_menu_item('settings', [
				'href'     => admin_url('settings'),
				'name'     => _l('acs_settings'),
				'position' => 200,
			]);
		}
    }
}
