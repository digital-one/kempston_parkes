<?php
require_once('./classes/component.php');

class tabbedPane extends component
{
	var $tabsNum=0;
	var $currentTab=0;
	var $tabs;
	
	function tabbedPane($id="tabbedPane1")
	{
		$this->css="defaultTabbedPane";
		$this->defaultTabbedPaneHeaderCss="defaultTabbedPaneHeader";
		$this->defaultTabbedPaneHeaderSelectedCss="defaultTabbedPaneHeaderSelected";
		$this->id=$id;
		if(is_numeric($_GET["tab"])) $this->currentTab=$_GET["tab"];
	}
	
	function addComponent($component,$title="Unnamed")
	{
		$this->tabs[$this->tabsNum][0]=$title;
		$this->tabs[$this->tabsNum][1]=$component->getComponent();
		$this->tabsNum++;
		$this->createTable();		
	}

	function createTable()
	{
		global $LINK;
		
		for($i=0;$i<$this->tabsNum;$i++)
		{
			$tabId=$this->id.'tab'.$i;
			$headerId=$this->id.'header'.$i;
			
			if($i==0) 
			{
				$defaultHeaderId=$headerId;
				$defaultTabId=$tabId;
				$class=$this->defaultTabbedPaneHeaderSelectedCss;
				$style="position:static;visibility:visible;";
			}
			else 
			{
				$class=$this->defaultTabbedPaneHeaderCss;
				$style="position:absolute;visibility:hidden;";
			}
			
			$tbs.='
				<div style="float:left;padding-right:1px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="width:2px;"><img src="images/tabbedPane3.gif" alt="" /></td>
						<td class="'.$class.'" id="'.$headerId.'"><a href="javascript:displaySelectedTab'.$this->id.'(\''.$tabId.'\',\''.$headerId.'\')">'.$this->tabs[$i][0].'</a></td>
						<td style="width:2px;"><img src="images/tabbedPane4.gif" alt="" /></td>
					</tr>
				</table>
				</div>';
				
			$content.='<div id="'.$tabId.'" style="'.$style.'">'.$this->tabs[$i][1].'</div>';
			
		}
		

		
		$this->html='
		<script type="text/javascript">
		
		var selectedHeaderId'.$this->id.'=\''.$defaultHeaderId.'\';
		var selectedTabId'.$this->id.'=\''.$defaultTabId.'\';
		
		function displaySelectedTab'.$this->id.'(tabId,headerId)
		{
			document.getElementById(selectedHeaderId'.$this->id.').className="'.$this->defaultTabbedPaneHeaderCss.'";
			document.getElementById(headerId).className="'.$this->defaultTabbedPaneHeaderSelectedCss.'";
			selectedHeaderId'.$this->id.'=headerId;
			
			document.getElementById(selectedTabId'.$this->id.').style.visibility="hidden";
			document.getElementById(selectedTabId'.$this->id.').style.position="absolute";
			
			document.getElementById(tabId).style.visibility="visible";
			document.getElementById(tabId).style.position="static";
			selectedTabId'.$this->id.'=tabId;
		}
		
		</script>
		
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr><td>'.$tbs.'</td></tr>
				<tr><td class="'.$this->css.'"><div id="'.$this->id.'">'.$content.'</div></td></tr>
			</tbody>
		</table>';
	}
	
}

