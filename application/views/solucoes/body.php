    <div id="Coaching">
        <section id="services" class="service-item">
           <div class="container">
                <div class="center wow fadeInDown">
                <br /><br />
                    <h2>Soluções</h2>
                    <p class="lead">Algumas das soluções prestadas por nós.</p>
                </div>

                <div class="row">
                    <?php if ($this->session->flashdata('sucesso') == 'true'): ?>
                        <?php $this->session->set_flashdata('sucesso', ''); ?>
                        <div class="col-md-12 col-xs-12 wow fadeInDown">
                            <div class="alert alert-success">
                                <strong>Sucesso!</strong> Um email foi enviado com sua solicitação, em breve retornaremos o contato.
                            </div>
                        </div>
                    <?php elseif($this->session->flashdata('sucesso') == 'false'): ?>
                        <?php $this->session->set_flashdata('sucesso', ''); ?>
                        <div class="col-md-12 col-xs-12 wow fadeInDown">
                            <div class="alert alert-danger">
                                <strong>Erro!</strong> Houve um problema ao enviar o email, por favor tente novamente.
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services1.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Consultório de Psicologia</h5>
                                    <p class="card-text">Busca aumentar o desempenho organizacional a partir de um trabalho personalizado, para atender as necessidades de um negócio, de uma área ou de uma equipe.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Entrar em Contato.</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Contato</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para que possamos retornar o contato.<br/>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formSolucoes/0" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12"></div>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services3.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Atendimento em Coaching</h5>
                                    <p class="card-text">Visa potencializar a performance dos executivos por meio do aumento da eficácia do líder, da capacidade de influenciar, formar, desenvolver e liderar times de alta performance, elevando a motivação, engajamento e produtividade das equipes.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Entrar em Contato.</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Contato</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para que possamos retornar o contato.<br/>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formSolucoes/1" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flip-container col-md-6 col-xs-12 wow fadeInDown" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front card">
                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/services/services4.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Para Empresas</h5>
                                    <p class="card-text">Consultoria Organizacional, Avaliação 360, Recrutamento e Seleção, Palestra e Treinamento.</p>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Entrar em Contato.</button>
                                </div>
                            </div>
                            <div class="back card">
                                <div class="card-body">
                                    <h5 class="card-title">Contato</h5>
                                    <p class="card-text">
                                        Por favor, preencha o formulário abaixo para que possamos retornar o contato.<br/>
                                    </p>
                                    <form class="form-matricula" action="<?php echo base_url(); ?>index.php/site/formSolucoes/2" method="POST">
                                        <div class="col-md-12 col-xs-12">
                                            <label>Nome completo *</label>
                                            <input type="text" name="matricula-nome" class="form-control">
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <label>Email *</label>
                                            <input type="text" name="matricula-email" class="form-control email">
                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <label>Telefone *</label>
                                            <input type="text" name="matricula-telefone" class="form-control telefone">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button href="#" class="btn btn-primary">Voltar</button>
                                    <button href="#" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--/.row-->
            </div><!--/.container-->
        </section><!--/#services-->
    </div>
    
