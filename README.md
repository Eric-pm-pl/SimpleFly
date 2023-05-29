[![](https://poggit.pmmp.io/shield.state/SimpleFly)]
[![Discord](https://img.shields.io/discord/1100650029573738508.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/yAhsgskaGy)
<div align="center">
<h1>SimpleFly| v1.0.0<h1>
<p>Help to fly in survival mode.</p>
</div>

# Features
- Using simple
- Fly in survival mode

 <br>
  
# All SimpleFly Commands:

| **Command** | **Description** |
| --- | --- |
| **/fly** | **Fly mode** |
<br>
  
## 📃  Permissions:

- You can use permission `simplefly.command` for command /fly
<br>
  
# Configs
## config.yml
 ```
 ---
#   ____  _                 _      _____ _       
 # / ___|(_)_ __ ___  _ __ | | ___|  ___| |_   _ 
 # \___ \| | '_ ` _ \| '_ \| |/ _ \ |_  | | | | |
 #  ___) | | | | | | | |_) | |  __/  _| | | |_| |
 # |____/|_|_| |_| |_| .__/|_|\___|_|   |_|\__, |
 #                   |_|                   |___/ 
# Main config of SimpleFly
# Messages
fly.creative: "You can't do this while in creative mode!"
fly.on: "Fly mode is on."
fly.off: "Fly mode is off."
fly.other.creative: "{PLAYER} is in creative mode!"
fly.other.on: "Fly mode of {PLAYER} is on."
fly.other.off: "Fly mode of {PLAYER} is off."
fly.other.not-found: "This player could not be found!"
join.disable: "Your fly mode has been disabled when joining the server!"
world-move.disable: "Your fly mode has been disabled when move the world!"
damage.disable: "Your fly mode has been disabled when fighting!"
# When players join the server fly mode will be disabled when set to true
event.join.reset: true 
# When the player moves the world fly mode will be turned off when set to true
event.world-move.disable: true 
# When the player fighting fly mode will be turned off when set to true
event.damage.disable: true
...
 ```
