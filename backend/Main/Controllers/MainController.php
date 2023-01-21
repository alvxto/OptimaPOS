<?php

namespace BackEnd\Main\Controllers;

use BackEnd\Menu\Models\Menu;

use App\Libraries\Collection;
use App\Libraries\Parser;

class MainController extends \App\Core\BaseController
{
	public function index()
	{
		$menu = $this->getMenu(session()->UserId);
		$data = [
			'navbar' => $menu['navbar'],
			'sidebar' => $menu['sidebar'],
			'roles'	=> array_column(session()->Rules, 'menu_code'),
			'fullname' => session()->Fullname,
			'email' => session()->Email,
			'photoProfile' => base_url() . '/manages/file/uploads-users-thumbs-' . session()->UserId . '.jpg'
		];
		Parser::view('BackEnd\Layout\Views\main', $data);
	}

	/**
	 * 
	 * @return 
	 * */
	public function getPage()
	{
		$data 					= getPost();
		$operation 				= (new Menu())->find($data['con']);
		$module 			    = explode('-', $operation['menu_code']);
		$fileView 				= (count($module) == 1) ? 'index' : $module[1];
		$viewPath		        = 'BackEnd\\' . ($module[0]) . '\\Views\\' . $fileView;
		$operation['view'] 	    = base64_encode(view($viewPath));
		$operation['isLogin']   = (session()->UserId != '') ? true : false;

		return $this->respond($operation, 200);
	}

	public function getMenu($userId)
	{
		$operation = (new Menu())
			->setView('v_role_menus')->where(['menu_active' => 1, 'user_id' => $userId])
			->orderBy('menu_order', 'ASC')->findAll();

		$collect = new Collection($operation);

		return [
			'navbar' => $this->getNavbar($collect->where('menu_navbar', 1)->findAll()),
			'sidebar' => $this->getSidebar($collect->where('menu_navbar', 0)->findAll())
		];
	}

	/**
	 * @return html menu navbar
	 * */
	public function getNavbar($data)
	{
		$collect  	= new Collection($data);
		$menuNavbar = $collect->where(['menu_level' => 1, 'menu_navbar' => 1])->findAll();
		$htmlNavbar = '';
		foreach ($menuNavbar as $keyNavbars => $menuNavbars) {
			$menuIcon = ($menuNavbars['menu_icon'] != '') ? "<span class=\"menu-icon\"><i class=\"{$menuNavbars['menu_icon']}\"></i></span>" : "";
			if ($menuNavbars['menu_hassub'] == 1) {
				$htmlNavbar .= "
					<div data-kt-menu-trigger=\"click\" data-kt-menu-placement=\"bottom-start\" class=\"menu-item menu-lg-down-accordion me-lg-5\">
						<span class=\"menu-link py-3\">
							{$menuIcon}
							<span class=\"menu-title\">{$menuNavbars['menu_title']}</span>
							<span class=\"menu-arrow d-lg-none\"></span>
						</span>
						<div class=\"menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px\"> ";
				foreach ($collect->where(['menu_level' => 2, 'menu_parent' => $menuNavbars['menu_id']])->findAll() as $keySub => $valueSub) {
					$iconSub = ($valueSub['menu_icon']) ? "<span class=\"menu-icon\"><i class=\"{$valueSub['menu_icon']}\"></i></span>" : "";
					if ($valueSub['menu_hassub'] == 1) {
						$htmlNavbar .= "<div data-kt-menu-trigger=\"{default:'click', lg: 'hover'}\" data-kt-menu-placement=\"right-start\" class=\"menu-item menu-lg-down-accordion\">
										<span class=\"menu-link py-3\">
											{$iconSub}
											<span class=\"menu-title\">{$valueSub['menu_title']}</span>
											<span class=\"menu-arrow\"></span>
										</span>
										<div class=\"menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px\">";
						foreach ($collect->where(['menu_level' => 3, 'menu_parent' => $valueSub['menu_id']])->findAll() as $keySub3 => $valueSub3) {
							$htmlNavbar .= "
													<div class=\"menu-item\">
														<a class=\"menu-link py-3\" href=\"javascript:;\" data-con=\"{$valueSub3['menu_id']}\" onclick=\"HELPER.loadPage(this)\">
															<span class=\"menu-bullet\">
																<span class=\"bullet bullet-dot\"></span>
															</span>
															<span class=\"menu-title\">{$valueSub3['menu_title']}</span>
														</a>
													</div>
												";
						}
						$htmlNavbar .= "</div>
									</div>";
					} else {
						$htmlNavbar .= "
										<div class=\"menu-item\">
											<a class=\"menu-link py-3\" href=\"javascript:;\" data-con=\"{$valueSub['menu_id']}\" onclick=\"HELPER.loadPage(this)\" title=\"{$valueSub['menu_description']}\" data-bs-toggle=\"tooltip\" data-bs-trigger=\"hover\" data-bs-dismiss=\"click\" data-bs-placement=\"right\">
												{$iconSub}
												<span class=\"menu-title\">{$valueSub['menu_title']}</span>
											</a>
										</div>
									";
					}
				}
				$htmlNavbar .= "</div>
					</div>
				";
			} else {
				$htmlNavbar .= "
					<div class=\"menu-item me-lg-1\">
						<a class=\"menu-link py-3\" href=\"javascript:;\" data-con=\"{$menuNavbars['menu_id']}\" onclick=\"HELPER.loadPage(this)\">
							{$menuIcon}
							<span class=\"menu-title\">{$menuNavbars['menu_title']}</span>
						</a>
					</div>
				";
			}
		}

		return $htmlNavbar;
	}

	public function getSidebar($data = '')
	{
		$collect = new Collection($data);
		$html = '';
		foreach ($collect->where(['menu_level' => 1, 'menu_navbar' => 0])->findAll() as $key => $value) {
			$menuIcon = ($value['menu_icon'] != '') ? "<span class=\"menu-icon\"><i class=\"{$value['menu_icon']}\"></i></span>" : "";
			if ($value['menu_hassub'] == 1) {
				$html .= "
					<div data-kt-menu-trigger=\"click\" class=\"menu-item menu-accordion\">
						<span class=\"menu-link\">
							{$menuIcon}
							<span class=\"menu-title\">{$value['menu_title']}</span>
							<span class=\"menu-arrow\"></span>
						</span>
						<div class=\"menu-sub menu-sub-accordion menu-active-bg\">";
				foreach ($collect->where(['menu_level' => 2, 'menu_parent' => $value['menu_id']])->findAll() as $keySub => $valueSub) {
					$html .= "
									<div class=\"menu-item\">
										<a class=\"menu-link\" href=\"javascript:;\" data-con=\"{$valueSub['menu_id']}\" onclick=\"HELPER.loadPage(this)\">
											<span class=\"menu-bullet\">
												<span class=\"bullet bullet-dot\"></span>
											</span>
											<span class=\"menu-title\">{$valueSub['menu_title']}</span>
										</a>
									</div>
								";
				}
				$html .= "</div>
					</div>
				";
			} else {
				$html .= "
					<div class=\"menu-item\">
						<a class=\"menu-link\" href=\"javascript:;\" data-con=\"{$value['menu_id']}\" onclick=\"HELPER.loadPage(this)\">
							{$menuIcon}
							<span class=\"menu-title\">{$value['menu_title']}</span>
						</a>
					</div>
				";
			}
		}

		return $html;
	}
}
