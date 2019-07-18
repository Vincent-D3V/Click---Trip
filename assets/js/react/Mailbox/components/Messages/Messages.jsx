import React, { useState, useEffect, Fragment } from 'react';
import axios from 'axios';
import _ from 'underscore';
import Routing from '../../../../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

// COMPONENTS
import { Form, Image, List, Message } from 'semantic-ui-react';

// CSS
import './Messages.css';

function Messages(props) {
  const [allMessages, setAllMessages] = useState([]);
  const [convs, setConvs] = useState([]);
  const [messages, setMessages] = useState([]);
  const [input, setInput] = useState('');
  const [target, setTarget] = useState('admin');

  useEffect(() => {
    getAllMessages();
  }, []);

  useEffect(() => {
    viewDown();
  });

  const viewDown = () => {
    document.getElementById('divbottom').scrollIntoView({ behavior: "smooth" });
  };

  const getAllMessages = async () => {
    let response = await axios.get(Routing.generate('api_messages', { 'user': props.userType, 'id': props.userId }));
    setAllMessages(response.data.sort(function (a, b) {
      return new Date(a.sendAt).getTime() - new Date(b.sendAt).getTime();
    }));
    setConvs(_.uniq(response.data.map((e) =>
      { switch(props.userType){
        case 'client': 
            return e.agency;
        case 'agency': 
            return e.client;
        case 'user':
            return (e.sender==='admin'?(e.receiver==='client'?e.client:e.agency):(e.sender==='client'?e.client:e.agency))
      }}), obj => obj.id ));
    if (target == 'admin' && props.userType!=='user') {
      setMessages(response.data.filter(el => el.admin));
    } else if (props.userType === 'client') {
      setMessages(response.data.filter(el => el.agency.id == target.id && !el.admin && (el.sender=='client' || el.receiver=='client')));
    } else if (props.userType === 'agency') {
      setMessages(response.data.filter(el => el.client.id == target.id && !el.admin && (el.sender=='agency' || el.receiver=='agency')));
    } else if (props.userType === 'user') {
      setMessages(allMessages.filter(el => (el.client.id === target.id && (el.sender==='client' || el.receiver==='client') ) || (el.agency.id === e.id  && (el.sender ==='agency' || el.receiver ==='agency') ) ));
    }
  };

  const handleConv = (e) => {
    if (e == 'admin') {
      setMessages(allMessages.filter(el => el.admin));
      setTarget(e);
    } else if (props.userType === 'client') {
      setMessages(allMessages.filter(el => el.agency.id == e.id && !el.admin && (el.sender=='client' || el.receiver=='client')));
      setTarget(e);
    } else if (props.userType === 'agency') {
      setMessages(allMessages.filter(el => el.client.id == e.id && !el.admin && (el.sender=='agency' || el.receiver=='agency')));
      setTarget(e);
    } else if (props.userType === 'user') {
      setMessages(allMessages.filter(el => (el.client.id === e.id && (el.sender==='client' || el.receiver==='client') ) || (el.agency.id === e.id  && (el.sender==='agency' || el.receiver==='agency') ) ));
      setTarget(e);
    }

    document.getElementsByClassName('item').forEach(element => {
        if(element.classList.contains('selected')){
          document.getElementsByClassName('selected')[0].classList.remove('selected');
        }
    });
    document.getElementById(`conv-${e.id}`).classList.add('selected');
    viewDown();
  };

  const handleSubmit = () => {
    let info = {};
    if (props.userType == 'client') {
      info.from = { id: messages[0].client.id, type: 'client' };
      info.to = { id: messages[0].agency.id, type: 'agency' };
    } else if (props.userType == 'agency') {
      info.from = { id: messages[0].agency.id, type: 'agency' };
      info.to = { id: messages[0].client.id, type: 'client' };
    } else if (props.userType == 'user'){
      info.from = { id: 0, type: 'user'};
      if(messages[0].sender=='client' || messages[0].receiver=='client'){
        info.to = {id: messages[0].client.id, type: 'client'}
      } else {
        info.to = {id: messages[0].agency.id, type: 'agency'}
      }
    }
    info.content = input;
    info.adminBool = messages[0].admin;
    info.idHistory = messages[0].histories.id;

    axios.post(Routing.generate('profil_send_message'), info)
      .then(() => {
        getAllMessages();
        setInput('');
      })
      .then(() => {
        if (props.userType === 'client') {
          setMessages(allMessages.filter(e => e.agency.id === messages[0].agency.id && !e.admin && (e.sender=='client' || e.receiver=='client')));
        } else if (props.userType === 'agency') {
          setMessages(allMessages.filter(e => e.client.id === messages[0].client.id && !e.admin && (e.sender=='agency' || e.receiver=='agency')));
        } else if (props.userType === 'user') {
          if(messages[0].sender=='client' || messages[0].receiver=='client'){
            setMessages(allMessages.filter(e => e.client.id === messages[0].client.id && e.admin));
          } else {
            setMessages(allMessages.filter(e => e.agency.id === messages[0].agency.id && e.admin));
          }
        }
      });
  };

  const convDisplay=(e) =>
  { 
    if(props.userType==='client'){
      return `agence: ${e.company}`;
    }
    if(props.userType==='agency'){
      return `client: ${e.surname}`;
    }
    if(props.userType==='user'){
      return (e.company!=null?`agence: ${e.company}`:`client: ${e.surname}`);
    }
  }



  return (
    <Fragment>
      <div className="Conversations">
        <button onClick={()=> console.log('messages:', messages)}></button>
        <List selection verticalAlign="middle">
          {
            props.userType !== 'user' &&
            <List.Item id="conv-0" className="selected" onClick={() => handleConv('admin')}>
              <Image avatar src="../images/small-logo.png" />
              <List.Content>
                <List.Header>admin</List.Header>
              </List.Content>
            </List.Item>
          }
          {
            convs.map((e, i) => {
              return (
                <List.Item key={i} id={`conv-${e.id}`} onClick={() => handleConv(e)}>
                  <Image avatar src={e.avatar} />
                  <List.Content>
                      <List.Header>
                        {convDisplay(e)}
                      </List.Header>
                  </List.Content>
                </List.Item>
              );
            })
          }
        </List>
      </div>
      <div className="Messages">
        <div className="list-messages">
          <button onClick={() => {debugger}}></button>
          {messages.map((e, i) => {
            return (
              <Message key={i} className={props.userType === e.sender ? ' right' : ' left'}>
                {e.content}
                {()=> {if(props.userType=='user'){return <small>{e.sender}</small>}  }}
              </Message>
            )
          })}
          <div id="divbottom"></div>  
        </div>
        <div className="write-send">
          <Form onSubmit={() => { input !== '' && handleSubmit() }}>
            <Form.Group>
              <Form.Input placeholder="Ecrire un message" value={input} onChange={(event) => setInput(event.target.value)} />
              <Form.Button content=">" />
            </Form.Group>
          </Form>
        </div>
      </div>
    </Fragment>
  )
}

export default Messages;
