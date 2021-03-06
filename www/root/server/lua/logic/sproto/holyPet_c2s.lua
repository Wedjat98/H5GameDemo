--*******************head
local server = require "server"
local lua_app = require "lua_app"
local lua_util = require "lua_util"

--[[
#领取奖励
cs_holy_pet_get_reward 6101 {
	request {
		no 			0 : integer #领取第几个奖励
	}
}
]]
function server.cs_holy_pet_get_reward(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    server.holyPetCenter:GetReward(player.dbid, msg.no)
end

--[[
#抽奖
cs_holy_pet_luck_draw 6103 {
	request {
	}
	response {
		ret 	0 : boolean #
		no 		1 : integer #抽到了啥
		data 	2 : *holy_pet_msg #抽奖信息
		luckLog	3 : *integer #玩家抽取记录
	}
}
]]
function server.cs_holy_pet_luck_draw(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return server.holyPetCenter:LuckDraw(player.dbid)
end

--[[
#获取抽奖信息
cs_holy_pet_get_info 6102 {
	request {
	}
	response {
		data 		0 : *holy_pet_msg #抽奖信息
		luckLog		1 : *integer #玩家抽取记录
	}
}
]]
function server.cs_holy_pet_get_info(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    local msg = {}
    msg.data = server.holyPetCenter:GetData()
    msg.luckLog = server.holyPetCenter:GetLuckLog(player.dbid)
    return msg
end
