 <?php
		
	class menu_generator{

		private $_ci;
		private $arr_menu;
		private $menu_type;
		private $dao;

		public function __construct($dao=null)
		{			
			$this->_ci =& get_instance();
			$this->bundle_type = '';
			$this->tax_type = '';
			$this->arr_menu = array();
			$this->tree = array();
			$this->dao = $dao;
		}

		function initialize_dao($dao){
			$this->dao = $dao;
		}		

		public function prepare_data($bundle_type,$tax_type,$bundle_id){
						
			$this->bundle_type = $bundle_type;
			$this->tax_type = $tax_type;


            $user_type_id = $this->_ci->session->userdata('user_type_id');

			$sql = "SELECT b.menu_id,b.level,b.reference,b.title,b.url,b.description,b.image FROM user_privileges as a INNER JOIN 
					(SELECT x.menu_bundle_id,y.* FROM menu_bundles as x INNER JOIN (SELECT * FROM menu_navigations WHERE showed=TRUE) as y ON (x.menu_navigation_id=y.menu_id) 
					 WHERE x.showed=TRUE) as b ON  (a.menu_bundle_id=b.menu_bundle_id) 
 					WHERE (a.user_type_id='".$user_type_id."') AND (a.bundle_id='".$bundle_id."') 
 					ORDER BY a.privilege_id";
 			
			$rows = $this->dao->execute(0,$sql)->result_array();
			
			foreach ($rows as $row) {
				$this->arr_menu[$row['menu_id']] = array('title'=>$row['title'],'url'=>$row['url'],'desc'=>$row['description'],'img'=>$row['image']);
				$this->tree[$row['menu_id']] = ($row['reference']==0?null:$row['reference']);
			}
		}

		public function get_parsed_tree(){
			$parsed_tree = $this->parse_tree($this->tree);			
			return $parsed_tree;
		}

		private function parse_tree($tree,$root=null){

			$return = array();
			$_parent = false;
			$master_root = false;

			# Traverse the tree and search for direct children of the root
			foreach($tree as $child => $parent){

				if($parent==$root){

					$master_root = ($root==null);

					#remote item from tree (we don't need to traverse this again)
					unset($tree[$child]);

					$_parent = (in_array($child,$tree));

					$return[] = array('name'=>$child,
									  'parent'=>$_parent,
									  'master_root'=>$master_root,
									  'children'=>$this->parse_tree($tree,$child)
						);
				}
			}
			return (count($return)==0?null:$return);
		}

		public function print_tree($tree,$type,$n){
			

			if(!is_null($tree) && count($tree)>0){

				$ulClass=($type=='master'?"":" class='dropdown-menu'");

				if($n>1)
				{
					echo "<ul".$ulClass.">";
				}

				$arr_menu = $this->arr_menu;

				foreach($tree as $node){
					$id = $node['name'];

					$liClass1 = ($node['parent']?"treeview":"");
					$href = $arr_menu[$id]['url']!='#' && $arr_menu[$id]['url']!=''?base_url().str_replace('{bundle}', $this->bundle_type.'/'.$this->tax_type, $arr_menu[$id]['url']):'#';

					echo "<li><a href='".$href."' title='".$arr_menu[$id]['desc']."'>";
					if(!empty($arr_menu[$id]['img'])){
						echo "<i class='".$arr_menu[$id]['img']."'></li>";
					}

					echo $arr_menu[$id]['title'];
					if($node['parent']){
						echo "&nbsp;<span class='caret'></span>";
					}
					echo "</a>";
					$this->print_tree($node['children'],'child',$n+1);
					echo "</li>";
				}
				
				if($type!='master')
					echo "</ul>";
			}			
		}
	}
?>