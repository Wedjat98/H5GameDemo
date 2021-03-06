--*******************head
local server = require "server"
local lua_app = require "lua_app"
local lua_util = require "lua_util"

--[[
#客户端->服务端
#激活
cs_formation_activation 5601 {
	request {
		no			0 : integer #阵法编号
	}
	response {
		no				0 : integer #阵法编号
		skillNo			1 : integer #技能
		lv				2 : integer #等级
		upNum			3 : integer #升级经验次数
		soulLv			4 : integer #阵魂等级
		soulUpNum		5 : integer #阵魂升级经验次数
	}
}
]]
function server.cs_formation_activation(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:Activation(msg.no)
end

--[[
#使用属性丹
cs_formation_drug 5602 {
	request {
		useNum			0 : integer #使用多少个丹数
	}
	response {
		ret				0 : boolean #
		drugNum			1 : integer #已使用属性丹数量
	}
}
]]
function server.cs_formation_drug(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:UseDrug(msg.useNum)
end

--[[
#加经验
cs_formation_add_exp 5603 {
	request {
		no				0 : integer #
		autoBuy			1 : integer #0不自动购买道具1使用绑元宝2使用绑元宝和元宝
	}
	response {
		ret				0 : boolean #
		no				1 : integer #
		lv				2 : integer #
		upNum			3 : integer #
	}
}
]]
function server.cs_formation_add_exp(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:AddExp(msg.no, msg.autoBuy)
end

--[[
#加阵魂经验
cs_formation_soul_add_exp 5604 {
	request {
		no				0 : integer #
		autoBuy			1 : integer #0不自动购买道具1使用绑元宝2使用绑元宝和元宝
	}
	response {
		ret				0 : boolean #
		no				1 : integer #
		soulLv			2 : integer #
		soulUpNum		3 : integer #
	}
}
]]
function server.cs_formation_soul_add_exp(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:SoulAddExp(msg.no, msg.autoBuy)
end

--[[
#使用
cs_formation_use 5605 {
	request {
		no				0 : integer #
	}
	response {
		ret				0 : boolean #
		use				1 : integer #使用的阵
		disuse			2 : integer #被卸下的阵
	}
}
]]
function server.cs_formation_use(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:Use(msg.no)
end

--[[
#升级技能
cs_formation_skill_up 5606 {
	request {
		no				0 : integer #
	}
	response {
		ret				0 : boolean #
		skillNo			1 : integer #技能No
	}
}
]]
function server.cs_formation_skill_up(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.formation:SkillUp(msg.no)
end
