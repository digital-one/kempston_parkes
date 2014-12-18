<?php
require_once('./classes/component.php');

class tabbedPane extends component
{
	var $tabsNum=0;
	var $currentTab=0;
	var $tabs;
	
	function tabbedPane()
	{
		$this->css="defaultTabbedPane";
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
			if($this->currentTab==$i)
			{
				$tbs.='
				<div style="float:left;padding-right:1px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="width:2px;"><img src="images/tabbedPane1.gif" alt="" /></td>
						<td class="defaultTabbedPaneItemSelected">'.$this->tabs[$i][0].'</td>
						<td style="width:2px;"><img src="images/tabbedPane2.gif" alt="" /></td>
					</tr>
				</table>
				</div>';
			}
			else
			{
				$tbs.='
				<div style="float:left;padding-right:1px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="width:2px;"><img src="images/tabbedPane3.gif" alt="" /></td>
						<td class="defaultTabbedPaneItem"><a href="'.$LINK->getLink("tab=".$i).'">'.$this->tabs[$i][0].'</a></td>
						<td style="width:2px;"><img src="images/tabbedPane4.gif" alt="" /></td>
					</tr>
				</table>
				</div>';
			}
		}
		
		$this->html= '
		<table cellpadding="0" cellspacing="0" border="0">
			<tbody>
				<tr><td>'.$tbs.'</td></tr>
				<tr><td class="'.$this->css.'">'.$this->tabs[$this->currentTab][1].'</td></tr>
			</tbody>
		</table>';
	}
	
}

