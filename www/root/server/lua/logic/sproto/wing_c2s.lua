--*******************head
local server = require "server"
local lua_app = require "lua_app"
local lua_util = require "lua_util"

--[[
#翅膀升阶
cs_wing_upgrade_level 5101 {
	request {}
}
]]
function server.cs_wing_upgrade_level(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)

end

--[[
#翅膀升级技能
cs_wing_upgrade_skill 5102 {
	request {
		skillId			0 : integer			#技能id
	}
}
]]
function server.cs_wing_upgrade_skill(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)

end

--[[
#翅膀穿戴装备
cs_wing_equip 5103 {
	request {
		itemHandle		0 : integer
		pos 			1 : integer
	}
}
]]
function server.cs_wing_equip(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)

end

--[[
#翅膀幻化
cs_wing_dress 5104 {
	request {
		dressId 		0 : integer			#装扮id
	}
	response {
		result			0 : integer
		dressId			1 : integer
	}
}
]]
function server.cs_wing_dress(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)

end

--[[
#翅膀使用属性丹
cs_wing_drug 5105 {
	request {
		drugNum 		0 : integer			#属性丹数量
	}
	response {
		result			0 : integer
		drugTotal		1 : integer			#总属性丹数
	}
}
]]
function server.cs_wing_drug(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)

end
