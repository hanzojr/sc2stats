
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
@PreviousView("./player_list.jsf")
public class PlayerEditMB extends AbstractEditPageBean<Player, Long> {

	private static final long serialVersionUID = 1L;

	@Inject
	private PlayerBC playerBC;
	

	@Inject
	private GrupoBC grupoBC;
	
	public List<Grupo> getGrupoList(){
		return grupoBC.findAll();
	}
			
	
	@Override
	@Transactional
	public String delete() {
		this.playerBC.delete(getId());
		return getPreviousView();
	}
	
	@Override
	@Transactional
	public String insert() {
		this.playerBC.insert(this.getBean());
		return getPreviousView();
	}
	
	@Override
	@Transactional
	public String update() {
		this.playerBC.update(this.getBean());
		return getPreviousView();
	}
	
	@Override
	protected Player handleLoad(Long id) {
		return this.playerBC.load(id);
	}	
}