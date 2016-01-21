
package com.alqteam.sc2stats.view;

import javax.inject.Inject;
import br.gov.frameworkdemoiselle.annotation.PreviousView;
import br.gov.frameworkdemoiselle.stereotype.ViewController;
import br.gov.frameworkdemoiselle.template.AbstractEditPageBean;
import br.gov.frameworkdemoiselle.transaction.Transactional;
import com.alqteam.sc2stats.business.*;
import com.alqteam.sc2stats.domain.*;
import javax.faces.model.*;
import org.primefaces.event.TransferEvent;
import org.primefaces.model.DualListModel;
import java.util.*;

// To remove unused imports press: Ctrl+Shift+o

@ViewController
@PreviousView("./grupo_list.jsf")
public class GrupoEditMB extends AbstractEditPageBean<Grupo, Long> {

	private static final long serialVersionUID = 1L;

	@Inject
	private GrupoBC grupoBC;
	

	private DataModel<Player> playerList;
	
	public void addPlayer() {
		this.getBean().getListaPlayer().add(new Player());
	}
	public void deletePlayer() {
	   this.getBean().getListaPlayer().remove(getPlayerList().getRowData());
	}
	public DataModel<Player> getPlayerList() {
	   if (playerList == null) {
		   playerList = new ListDataModel<Player>(this.getBean().getListaPlayer());
	   }
	   return playerList;
	} 
	
	@Override
	@Transactional
	public String delete() {
		this.grupoBC.delete(getId());
		return getPreviousView();
	}
	
	@Override
	@Transactional
	public String insert() {
		this.grupoBC.insert(this.getBean());
		return getPreviousView();
	}
	
	@Override
	@Transactional
	public String update() {
		this.grupoBC.update(this.getBean());
		return getPreviousView();
	}
	
	@Override
	protected Grupo handleLoad(Long id) {
		return this.grupoBC.load(id);
	}	
}